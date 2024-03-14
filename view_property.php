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

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('Location:./home.php');
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
    header('Location: ./view_property.php?get_id='. $get_id);
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
    header('Location: ./view_property.php?get_id='. $get_id);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Property</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- swiper cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    
<!-- header section -->
<?php require('./assets/components/user_header.php') ?>


<!-- view-property section -->
<section class="view-property">

        <h1 class="heading">property details</h1>
    
        <?php 
            $select_property = $conn->prepare("SELECT * FROM `property` WHERE id= ? LIMIT 1");
            $select_property->execute(array($get_id));
            if($select_property->rowCount() > 0){
                while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){
                
                $property_id = $fetch_property['id'];

                $select_users = $conn->prepare("SELECT * FROM  `users` WHERE id= ? LIMIT 1");
                $select_users->execute(array($user_id));
                $fech_users = $select_users->fetch(PDO::FETCH_ASSOC);

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id= ? AND
                user_id= ?");
                $select_saved->execute(array($property_id, $user_id));
                $fetch_saved = $select_saved->fetch(PDO::FETCH_ASSOC);
        ?>

            
            <div class="details">

                <div class="swiper image-container">
                    <div class="swiper-wrapper">
                        <img src="./assets/uploadped_img/<?= $fetch_property['image_01']; ?>" 
                        alt="" class="swiper-slide">
                        <?php if(!empty($fetch_property['image_02'])){ ?>
                            <img src="./assets/uploadped_img/<?= $fetch_property['image_02'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_03'])){ ?>
                            <img src="./assets/uploadped_img/<?= $fetch_property['image_03'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_04'])){ ?>
                            <img src="./assets/uploadped_img/<?= $fetch_property['image_04'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_05'])){ ?>
                            <img src="./assets/uploadped_img/<?= $fetch_property['image_05'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                    <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                    <p class="address"><i class="fas fa-map-marker-alt"></i> <span><?= $fetch_property['address']; ?></span></p>
                    <div class="info">
                        <p><i class="fas fa-dollar"></i><span><?= number_format($fetch_property['price']); ?></span></p>
                        <p><i class="fa fa-user"></i><span><?= $fech_users['name']; ?></span></p>
                        <p><i class="fa fa-phone"></i><a href="<?= $fech_users['number']; ?>"><?= $fech_users['number']; ?></a></p>
                        <p><i class="fas fa-building"></i><span><?= $fetch_property['offer']; ?></span></p>
                        <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
                        <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
                    </div>

                    <h3 class="title">details</h3>
                    <div class="flex">
                        <div class="box">
                            <p>rooms : <span><?= $fetch_property['bhk']; ?></span></p>
                            <p>deposit amount : <i class="fas fa-dollar" style="margin-right: .5rem;"></i><span><?= number_format($fetch_property['deposite']); ?></span></p>
                            <p>status : <span><?= $fetch_property['status']; ?></span></p>
                            <p>bedroom : <span><?= $fetch_property['bedroom']; ?></span></p>
                            <p>bathroom : <span><?= $fetch_property['bathroom']; ?></span></p>
                            <p>balcony : <span><?= $fetch_property['balcony']; ?></span></p>
                        </div>

                        <div class="box">
                            <p>carpet area : <span><?= $fetch_property['carpet']; ?>sqft</span></p>
                            <p>age : <span><?= $fetch_property['age']; ?> years</span></p>
                            <p>room floor : <span><?= $fetch_property['room_floor']; ?></span></p>
                            <p>furnished : <span><?= $fetch_property['furnished']; ?></span></p>
                            <p>loan : <span><?= $fetch_property['loan']; ?></span></p>
                        </div>
                    </div>  

                        <h3 class="title">amenities</h3>
                        <div class="flex">
                            <div class="box">
                                <p><i class="fas fa-<?php if($fetch_property['lift'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>lifts</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['security_guard'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>security guard</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['play_ground'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>play ground</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['garden'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>gardens</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['water_supply'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>water supply</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['power_backup'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>power backup</span></p>
                            </div>

                            <div class="box">
                                <p><i class="fas fa-<?php if($fetch_property['parking_area'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>parking area</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['gym'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>gym</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['shopping_mall'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>shopping mall</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['hospital'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>hospital</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['school'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>schools</span></p>
                                <p><i class="fas fa-<?php if($fetch_property['market_area'] == 'yes'){echo 'check';}else{echo 'times';}; ?>"></i>
                                <span>market area</span></p>
                            </div>
                        </div>
                    <div class="h3 title">description</div>
                    <p class="description"><?= $fetch_property['description']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                        <div class="flex-btn">
                            <?php
                                if($select_saved->rowCount() > 0){
                                ?>
                                <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
                                <?php
                                }else{ 
                                ?>
                                <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
                            <?php
                            }
                            ?>
                            <input type="submit" value="send enquiry" name="send" class="btn">
                        </div>

                    </form>
            </div>

        <?php 
        }
        }else{
            echo '<p class="empty">property was no found!</p>';
        }
        ?>


</section>


<!-- footer section -->
<?php require('./assets/components/footer.php'); ?>

<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- swiper js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!-- custom js -->
<script src="./assets/js/app.js"></script>

<?php  require('./assets/components/message.php'); ?>

</body>
</html>