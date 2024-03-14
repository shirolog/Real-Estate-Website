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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- dashboard section -->
<section class="dashboard">

    <h1 class="heading">dashboard</h1>

    <div class="box-container">
       
        <div class="box">
            <?php 
                $select_users = $conn->prepare("SELECT * FROM  `users` WHERE id= ? LIMIT 1");
                $select_users->execute(array($user_id));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);
            ?>
            <h3>welcome!</h3>
            <p><?= $fetch_users['name']; ?></p>
            <a href="./update.php" class="btn">update profile</a>
        </div>
       
        <div class="box">
            <h3>filter search</h3>
            <p>search your dream property</p>
            <a href="./search.php" class="btn">search now</a>
        </div>

        <div class="box">
            <?php 
                $select_property = $conn->prepare("SELECT * FROM `property` WHERE user_id= ?");
                $select_property->execute(array($user_id));
                $total_listings = $select_property->rowCount();
            ?>
            <h3><?= $total_listings; ?></h3>
            <p>properties listed</p>
            <a href="./my_listings.php" class="btn">view my listings</a>
        </div>

        <div class="box">
            <?php 
                $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver= ?");
                $select_requests->execute(array($user_id));
                $total_requests = $select_requests->rowCount();
            ?>
            <h3><?= $total_requests; ?></h3>
            <p>requests received</p>
            <a href="./requests.php" class="btn">view all requests</a>
        </div>

        <div class="box">
            <?php 
                $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE sender= ?");
                $select_requests->execute(array($user_id));
                $total_requests = $select_requests->rowCount();
            ?>
            <h3><?= $total_requests; ?></h3>
            <p>requests received</p>
            <a href="./saved.php" class="btn">view saved properties</a>
        </div>

        <div class="box">
            <?php 
                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE user_id= ?");
                $select_saved->execute(array($user_id));
                $total_saved = $select_saved->rowCount();
            ?>
            <h3><?= $total_saved; ?></h3>
            <p>requests received</p>
            <a href="./saved.php" class="btn">view saved properties</a>
        </div>


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
