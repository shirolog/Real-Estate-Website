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

if(isset($_POST['delete'])){

    $delete_id = $_POST['property_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $select_property = $conn->prepare("SELECT * FROM `property` WHERE id= ?");
    $select_property->execute(array($delete_id));
    if($select_property->rowCount() > 0){
        $select_image = $conn->prepare("SELECT * FROM `property` WHERE id= ? LIMIT 1");
        $select_image->execute(array($delete_id));
        $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);

        $delete_image_01 = $fetch_image['image_01'];
        $delete_image_02 = $fetch_image['image_02'];
        $delete_image_03 = $fetch_image['image_03'];
        $delete_image_04 = $fetch_image['image_04'];
        $delete_image_05 = $fetch_image['image_05'];

        unlink('./assets/uploadped_img/'. $delete_image_01);

        if(!empty($delete_image_02)){
            unlink('./assets/uploadped_img/'. $delete_image_02);
        }

        if(!empty($delete_image_03)){
            unlink('./assets/uploadped_img/'. $delete_image_03);
        }

        if(!empty($delete_image_04)){
            unlink('./assets/uploadped_img/'. $delete_image_04);
        }

        if(!empty($delete_image_05)){
            unlink('./assets/uploadped_img/'. $delete_image_05);
        }

        $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id= ?");
        $delete_saved->execute(array($delete_id));

        $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE property_id= ?");
        $delete_requests->execute(array($delete_id));

        $delete_property = $conn->prepare("DELETE FROM `property` WHERE id= ?");
        $delete_property->execute(array($delete_id));

        $success_msg[] = 'listing deleted!';
        $_SESSION['success_msg'] = $success_msg;

    }else{
        $warning_msg[] = 'listing delete already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location: ./my_listings.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my listings</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>


<!-- my-listings section -->
<section class="my-listings">

    <h1 class="heading">my listings</h1>

    <div class="box-container">
        <?php 
            $select_property = $conn->prepare("SELECT * FROM  `property` WHERE user_id= ?
            ORDER BY date DESC");
            $select_property->execute(array($user_id));
            if($select_property->rowCount() > 0){
                while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_property['id'];
                
                if(!empty($fetch_property['image_02'])){
                    $image_02 = 1;
                }else{
                    $image_02 = 0;
                }
                
                if(!empty($fetch_property['image_03'])){
                    $image_03 = 1;
                }else{
                    $image_03 = 0;
                }
                
                if(!empty($fetch_property['image_04'])){
                    $image_04 = 1;
                }else{
                    $image_04 = 0;
                }
                
                if(!empty($fetch_property['image_05'])){
                    $image_05 = 1;
                }else{
                    $image_05 = 0;
                }

                $total_image = (1 + $image_02 + $image_03 + $image_04 + $image_05);
        ?>

                <form action="" method="post" class="box">
                    <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                    <div class="thumb">
                        <p><i class="fas fa-image"></i><span><?= $total_image; ?></span></p>
                        <img src="./assets/uploadped_img/<?= $fetch_property['image_01']; ?>" alt="">
                    </div>

                    <p class="price"><i class="fas fa-dollar-sign"></i>
                    <?= number_format($fetch_property['price']); ?> /-</p>
                    <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
                    <p class="address"><i class="fas fa-map-marker-alt"></i>
                    <?= $fetch_property['address']; ?></p>
                    <div class="flex-btn">
                        <a href="./update_property.php?get_id=<?= $property_id; ?>" 
                        class="btn">update</a>
                        <input type="submit" value="delete" name="delete" 
                        class="btn" onclick="return confirm('delete this listing?');">
                    </div>
                    <a href="./view_property.php?get_id=<?= $property_id; ?>" 
                    class="btn">view property</a>
                </form>

        <?php 
        }
        }else{
            echo '<p class="empty" style="margin-bottom: 400px;">no listings found!</p>';
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
