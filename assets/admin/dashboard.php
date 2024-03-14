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
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    
<!-- header section -->
<?php require('../components/admin_header.php'); ?>


<!-- dashboard section -->
<section class="dashboard">

    <h1 class="heading">dashboard</h1>

    <div class="box-container">

        <div class="box">
            <?php 
                $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE id= ? LIMIT 1");
                $select_admins->execute(array($admin_id));
                $fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC);
            ?>

            <h3>welcome!</h3>
            <p><?= $fetch_admins['name']; ?></p>
            <a href="./update.php" class="btn">update profile</a>
        </div>

        <div class="box">
            <?php 
                $select_property = $conn->prepare("SELECT * FROM `property`");
                $select_property->execute();
                $total_property = $select_property->rowCount();
            ?>

            <h3><?= $total_property; ?></h3>
            <p>total listings</p>
            <a href="./listings.php" class="btn">view listings</a>
        </div>

        <div class="box">
            <?php 
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                $total_users = $select_users->rowCount();
            ?>

            <h3><?= $total_users; ?></h3>
            <p>total users</p>
            <a href="./users.php" class="btn">view users</a>
        </div>

        <div class="box">
            <?php 
                $select_admins = $conn->prepare("SELECT * FROM `admins`");
                $select_admins->execute();
                $total_admins = $select_admins->rowCount();
            ?>

            <h3><?= $total_admins; ?></h3>
            <p>total admins</p>
            <a href="./admins.php" class="btn">view admins</a>
        </div>

        <div class="box">
            <?php 
                $select_messages = $conn->prepare("SELECT * FROM `messages`");
                $select_messages->execute();
                $total_messages = $select_messages->rowCount();
            ?>

            <h3><?= $total_messages; ?></h3>
            <p>total messages</p>
            <a href="../admin/message.php" class="btn">view messages</a>
        </div>

    </div>

</section>


<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>

</body>
</html>