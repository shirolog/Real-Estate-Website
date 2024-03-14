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

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('Location:./listings.php');
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
    header('Location:./view_property.php?get_id='. $get_id);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view property</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
    <!-- swiper cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- custom css -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    
<!-- header section -->
<?php require('../components/admin_header.php'); ?>

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
                $select_users->execute(array($fetch_property['user_id']));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

        ?>

            
            <div class="details">

                <div class="swiper image-container">
                    <div class="swiper-wrapper">
                        <img src="../uploadped_img/<?= $fetch_property['image_01']; ?>" 
                        alt="" class="swiper-slide">
                        
                        <?php if(!empty($fetch_property['image_02'])){ ?>
                            <img src="../uploadped_img/<?= $fetch_property['image_02'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_03'])){ ?>
                            <img src="../uploadped_img/<?= $fetch_property['image_03'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_04'])){ ?>
                            <img src="../uploadped_img/<?= $fetch_property['image_04'] ?>" alt=""
                            class="swiper-slide">
                         <?php 
                        }    
                        ?>   

                        <?php if(!empty($fetch_property['image_05'])){ ?>
                            <img src="../uploadped_img/<?= $fetch_property['image_05'] ?>" alt=""
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
                        <p><i class="fa fa-user"></i><span><?= $fetch_users['name']; ?></span></p>
                        <p><i class="fa fa-phone"></i><a href="<?= $fetch_users['number']; ?>"><?= $fetch_users['number']; ?></a></p>
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
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
                        <a href="./listings.php" class="option-btn">go back</a>
                        <input type="submit" name="delete" class="delete-btn" value="delete"
                        onclick="return confirm('delete this property?');">
                    </form>
            </div>

        <?php 
        }
        }else{
            echo '<p class="empty">property was not found!</p>';
        }
        ?>


</section>


<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<!-- swiper js cdn-->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



<!-- custom js -->
<script src="../js/admin.js"></script>


<!-- swiper js -->
<script src="../js/swiper.js"></script>



<?php  require('../components/message.php'); ?>
</body>
</html>