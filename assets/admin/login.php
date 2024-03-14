<?php 
require('../components/connect.php');
session_start();

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    
    $select_admins = $conn->prepare("SELECT * FROM  `admins` WHERE name= ? AND password= ?
    LIMIT 1");
    $select_admins->execute(array($name, $pass));
    $fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC);
    if($select_admins->rowCount() > 0){
        setcookie('admin_id', $fetch_admins['id'], time() + 60 * 60 * 24 * 14, '/');
        header('Location:./dashboard.php');
        exit();
    }else{
        $warning_msg[] = 'incorrect name or password!';
        $_SESSION['warning_msg'] = $warning_msg;
        header('Location:./login.php');
        exit();
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body style="padding-left: 0;">


<!-- form-container section -->
<section class="form-container">

    <form action=""  method="post">
        <h3>welcome back!</h3>
        <p>default name <span>admin</span> & password = <span>111</span></p>
        <input type="text" name="name" class="box" placeholder="enter your name" required
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="pass" class="box" placeholder="enter your password" required
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="submit" name="submit" class="btn" value="login now">
        
    </form>

</section>



<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>

</body>
</html>