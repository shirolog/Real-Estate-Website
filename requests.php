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

    $request_id = $_POST['request_id'];
    $request_id = filter_var($request_id, FILTER_SANITIZE_STRING);

    $select_requests= $conn->prepare("SELECT * FROM `requests` WHERE id= ?");
    $select_requests->execute(array($request_id));
    if($select_requests->rowCount() > 0){
        $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE id= ?");
        $delete_requests->execute(array($request_id));
        $success_msg[] = 'Request deleted!';
        $_SESSION['success_msg'] = $success_msg;
    }else{
        $warning_msg[] = 'Request deleted already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location:./requests.php');
    exit();


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>requests</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>


<!-- requests section -->
<section class="requests">

    <h1 class="heading">requests received</h1>

    <div class="box-container">

        <?php 
            $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver= ? ORDER BY date DESC");
            $select_requests->execute(array($user_id));
            if($select_requests->rowCount() > 0){
                while($fetch_requests = $select_requests->fetch(PDO::FETCH_ASSOC)){
            
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ?");
                $select_users->execute(array($fetch_requests['sender']));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                $select_property = $conn->prepare("SELECT * FROM  `property` WHERE id= ?");
                $select_property->execute(array($fetch_requests['property_id']));
                $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
        ?>

            <div class="box">
                <p>name : <span><?= $fetch_users['name']; ?></span> </p>
                <p>number : <a href="tel:<?= $fetch_users['number']; ?>"><?= $fetch_users['number']; ?></a></p>
                <p>email : <a href="tel:<?= $fetch_users['email']; ?>"><?= $fetch_users['email']; ?></a></p>
                <p>enquiry for : <a href="./view_property.php?get_id=<?= $fetch_property['id']; ?>"><?= $fetch_property['property_name']; ?></a></p>
                <form action="" method="post">
                    <input type="hidden" name="request_id" value="<?= $fetch_requests['id'] ?>">
                    <input type="submit" name="delete" class="btn" value="delete request" 
                    onclick="return confirm('delete this request?');">
                </form>
            </div>

        <?php 
        }
        }else{
            echo '<p class="empty" style="margin-bottom: 400px;">you have no requests!</p>';
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
