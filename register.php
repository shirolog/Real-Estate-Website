<?php 
require('./assets/components/connect.php');
session_start();


if(isset($_POST['submit'])){
    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email= ?");
    $select_users->execute(array($email));
    if($select_users->rowCount() > 0){
        $warning_msg[] = 'email already taken!';
        $_SESSION['warning_msg'] = $warning_msg;
        header('Location: ./register.php');
        exit();
    }else{
        if($pass != $cpass){
            $error_msg[] = 'password not matched!';
            $_SESSION['error_msg'] = $error_msg;
            header('Location: ./register.php');
            exit();
        }else{

            $insert_users = $conn->prepare("INSERT INTO `users` ( id, name , email, number, password) VALUES(?, ?, ?, ?, ?)");
            $insert_users->execute(array($id, $name, $email, $number, $cpass));
        
                $select_users = $conn->prepare("SELECT * FROM  `users` WHERE email= ? AND password= ?");
                $select_users->execute(array($email, $cpass));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                if($select_users->rowCount() > 0){
                    setcookie('user_id', $fetch_users['id'], time() + 60*60*24*30, '/');
                    header('Location: ./home.php');
                    exit();
                }else{
                    $error_msg[] = 'something went wrong!';
                    $_SESSION['error_msg'] = $error_msg;
                    header('Location: ./register.php');
                    exit();
                }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>


<!-- form-container section -->
<section class="form-container">

    <form action="" method="post">
        <h3>create an account</h3>
        <input type="text" name="name" class="box" required
        placeholder="enter your name" maxlength="50">
        <input type="email" name="email" class="box" required
        placeholder="enter your email" maxlength="50">
        <input type="number" name="number" class="box" required
        placeholder="enter your number" min="0" max="9999999999" maxlength="10">
        <input type="password" name="pass" class="box" required
        placeholder="enter your password" maxlength="20">
        <input type="password" name="cpass" class="box" required
        placeholder="confirm your password" maxlength="20">
        <p>already have an account? <a href="./login.php">login now</a></p>
        <input type="submit" name="submit" class="btn" value="register now">
    </form>

</section>



<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<!-- custom js -->
<script src="./assets/js/app.js"></script>


<?php  require('./assets/components/message.php'); ?>

</body>
</html>