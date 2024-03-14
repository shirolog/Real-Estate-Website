<?php 
require('./assets/components/connect.php');
session_start();


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email= ? 
    AND password= ? LIMIT 1");
    $select_users->execute(array($email, $pass));
    $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);
    if($select_users->rowCount() > 0){
        setcookie('user_id', $fetch_users['id'], time() + 60*60*24*30, '/');
        header('Location: ./home.php');
        exit();
    }else{
        $warning_msg[] = 'Incorrect email or password!';
        $_SESSION['warning_msg'] = $warning_msg;
        header('Location: ./login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    


<!-- form-container section -->
<section class="form-container">

    <form action="" method="post">
        <h3>welcome back!</h3>
        <input type="email" name="email" class="box" required
        placeholder="enter your email" maxlength="50">
        <input type="password" name="pass" class="box" required
        placeholder="enter your password" maxlength="20">
        <p>don't have an account? <a href="./register.php">register now</a></p>
        <input type="submit" name="submit" class="btn" value="login now">
    </form>

</section>




<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="./assets/js/app.js"></script>


<?php  require('./assets/components/message.php'); ?>

</body>
</html>