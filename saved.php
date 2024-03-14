<?php 
require('./assets/components/connect.php');
session_start();

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];

}else{
    setcookie('user_id', '', time() - 1, '/');
    header('Location:./login.php');
    exit();
}



if(isset($_POST['save'])){

    if($user_id != ''){
        $save_id = create_unique_id();
        $poperty_id = $_POST['property_id'];
        $poperty_id = filter_var($poperty_id, FILTER_SANITIZE_STRING);
        
        $select_saved =$conn->prepare("SELECT * FROM  `saved` WHERE property_id= ? AND
        user_id= ?");
        $select_saved->execute(array($poperty_id, $user_id));
        if($select_saved->rowCount() > 0){
            $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id= ? AND user_id= ?");
            $delete_saved->execute(array($poperty_id, $user_id));
            $success_msg[]= 'Remove from saved!';
            $_SESSION['success_msg'] = $success_msg;    
        }else{
            $insert_saved = $conn->prepare("INSERT INTO `saved`(id, property_id, user_id) VALUES(?, ?, ?)");
            $insert_saved->execute(array($save_id, $poperty_id, $user_id));
            $success_msg[]= 'Added to saved!';
            $_SESSION['success_msg'] = $success_msg;  
        }
       

    }else{
        $warning_msg[]= 'Please login first!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location: ./saved.php');
    exit();
}



if(isset($_POST['send'])){

    if($user_id != ''){
        $send_id = create_unique_id();
        $poperty_id = $_POST['property_id'];
        $poperty_id = filter_var($poperty_id, FILTER_SANITIZE_STRING);
        

        $select_property = $conn->prepare("SELECT * FROM `property` WHERE id=? 
        LIMIT 1");
        $select_property->execute(array($poperty_id));
        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
        $receiver = $fetch_property['user_id'];

        $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE property_id= ? AND
        sender= ?");
        $select_requests->execute(array($poperty_id, $user_id));
        if($select_requests->rowCount() > 0){
            $warning_msg[]= 'Request sent already!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $insert_requests= $conn->prepare("INSERT INTO `requests` (id, property_id, sender, receiver) VALUES
            (?, ?, ?, ?) ");
            $insert_requests->execute(array($send_id, $poperty_id, $user_id, $receiver));
            $success_msg[]= 'Request sent successfully!';
            $_SESSION['success_msg'] = $success_msg;  
        }
    }else{
        $warning_msg[]= 'Please login first!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location: ./saved.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>saved listings</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- listings section -->
<section class="listings">

    <h1 class="heading">saved listings</h1>

    <div class="box-container">
    
        <?php
            $select_save = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
            $select_save->execute(array($user_id));
            if($select_save->rowCount() > 0){
                while($fetch_save = $select_save->fetch(PDO::FETCH_ASSOC)){
                $select_property = $conn->prepare("SELECT * FROM `property` WHERE id= ?  ORDER BY date DESC");
                $select_property->execute(array($fetch_save['property_id']));
                if($select_property->rowCount() > 0){

                while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_property['id'];

                
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ?");
                $select_users->execute(array($user_id));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                if(!empty($fetch_property['image_02'])){
                    $count_image_02 = 1;
                }else{
                    $count_image_02 = 0;
                }

                if(!empty($fetch_property['image_03'])){
                    $count_image_03 = 1;
                }else{
                    $count_image_03 = 0;
                }

                if(!empty($fetch_property['image_04'])){
                    $count_image_04 = 1;
                }else{
                    $count_image_04 = 0;
                }

                if(!empty($fetch_property['image_05'])){
                    $count_image_05 = 1;
                }else{
                    $count_image_05 = 0;
                }
                
                $total_images = (1 + $count_image_02 + 
                $count_image_03 + $count_image_04 + $count_image_05);

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id= ? AND user_id= ?");
                $select_saved->execute(array($property_id, $user_id));
        ?>
           <form action="" method="post">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>remove from saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="./assets/uploadped_img/<?= $fetch_property['image_01']; ?> ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_users['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_users['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-dollar-sign"></i><span><?= number_format($fetch_property['price']); ?></span> /-</div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
            <?php 
            }
            }else{
                echo '<p class="empty">no property listed yet!</p>';
            }
            }
            }else{
                echo '<p class="empty" style="margin-bottom: 400px;">nothing saved yet!</p>';
            }
            ?>
    </div>

</section>
<!-- footer section -->
<?php require('./assets/components/footer.php'); ?>


<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="./assets/js/app.js"></script>

<?php  require('./assets/components/message.php'); ?>

</body>
</html>
