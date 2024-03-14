<?php 
require('../components/connect.php');
session_start();


if(isset($_COOKIE['admin_id'])){
    $admin_id = $_COOKIE['admin_id'];
}else{
    setcookie('admin_id', '', time() - 1, '/');
    header('Location: ../admin/login.php');
    exit();
}

if(isset($_POST['delete'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $select_property = $conn->prepare("SELECT * FROM `property` WHERE id= ? LIMIT 1");
    $select_property->execute(array($delete_id));
    if($select_property->rowCount() > 0){

        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);

        $delete_image_01 = $fetch_property['image_01'];
        $delete_image_02 = $fetch_property['image_02'];
        $delete_image_03 = $fetch_property['image_03'];
        $delete_image_04 = $fetch_property['image_04'];
        $delete_image_05 = $fetch_property['image_05'];

        unlink('../uploadped_img/'. $delete_image_01);

        if(!empty($delete_image_02)){
            unlink('../uploadped_img/'. $delete_image_02);            
        }

        if(!empty($delete_image_03)){
            unlink('../uploadped_img/'. $delete_image_03);            
        }

        if(!empty($delete_image_04)){
            unlink('../uploadped_img/'. $delete_image_04);            
        }

        if(!empty($delete_image_05)){
            unlink('../uploadped_img/'. $delete_image_05);            
        }

        $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id= ?");
        $delete_saved->execute(array($delete_id));

        $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE property_id= ?");
        $delete_requests->execute(array($delete_id));

        $delete_property = $conn->prepare("DELETE FROM `property` WHERE id= ?");
        $delete_property->execute(array($delete_id));
        
        $success_msg[]= 'Property  deleted!';
        $_SESSION['success_msg'] = $success_msg;  
    }else{
        $warning_msg[] = 'Property already deleted!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    
    if(isset($_POST['search_box'])){
        setcookie('search', 1 , time() + 60* 30, '/');
    }
    header('Location:./listings.php');
    exit();
}


if(isset($_COOKIE['search'])){
    $_POST['search_box'] = $_COOKIE['search_box'];
    $_POST['search_btn'] = '';
    setcookie('search', '', time() - 1, '/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listings</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    
<!-- header section -->
<?php require('../components/admin_header.php'); ?>

<!-- listings section -->
<section class="listings">

    <h1 class="heading">properties listed</h1>

    <form action="" method="post" class="search-form">
        <input type="text" name="search_box" placeholder="search listings..." maxlength="100"
        required>
        <button type="submit" name="search_btn" class="fas fa-search"></button>
    </form>

    <div class="box-container">
        <?php 
            if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
            
            $search_box = $_POST['search_box'];
            $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);

            $select_property = $conn->prepare("SELECT * FROM  `property` WHERE property_name
            LIKE '%{$search_box}%' OR address LIKE '%{$search_box}%' ORDER BY date DESC");
            $select_property->execute();

            setcookie('search_box', $search_box, time() + 60* 30, '/');


        }else{
            $select_property = $conn->prepare("SELECT * FROM  `property` ORDER BY date DESC");
            $select_property->execute();
        }
            if($select_property->rowCount() > 0){
                while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_property['id'];


                $select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ?");
                $select_users->execute(array($admin_id));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                if(!empty($fetch_property['image_02'])){
                    $image_02_count = 1;
                }else{
                    $image_02_count = 0;
                }

                if(!empty($fetch_property['image_03'])){
                    $image_03_count = 1;
                }else{
                    $image_03_count = 0;
                }

                if(!empty($fetch_property['image_04'])){
                    $image_04_count = 1;
                }else{
                    $image_04_count = 0;
                }

                if(!empty($fetch_property['image_05'])){
                    $image_05_count = 1;
                }else{
                    $image_05_count = 0;
                }

                $total_images = (1 + $image_02_count + $image_03_count + 
                $image_04_count + $image_05_count);                     
            ?>

              <div class="box">
                <div class="thumb">
                    <p><i class="fas fa-image"></i><span><?= $total_images; ?></span></p>
                    <img src="../uploadped_img/<?= $fetch_property['image_01']; ?>" alt="">
                </div>
                <p class="price"><i class="fas fa-dollar"></i><span><?= number_format($fetch_property['price']); ?></span></p>
                <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                <p class="address"><i class="fas fa-map-marker-alt"></i>
                <span><?=  $fetch_property['address']; ?></span></p>
                <form action="" method="post" class="flex-btn">
                    <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
                    <a href="./view_property.php?get_id=<?= $property_id; ?>" 
                    class="btn">view</a>
                    <input type="submit" name="delete" class="delete-btn" value="delete"
                    onclick="return confirm('delete this property?');">
                </form>
              </div>

        <?php 
        }
        }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
    

            echo '<p class="empty">no result found!</p>';
  
          
        }else{
      
  
            echo '<p class="empty">no property listed yet!</p>';
  
        }
        ?>
    
    </div>

</section>


<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>

</body>
</html>