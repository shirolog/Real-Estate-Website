<?php 
require('../components/connect.php');
session_start();


if(isset($_COOKIE['admin_id'])){
    $admin_id = $_COOKIE['admin_id'];
}else{
    $admin_id = '';
}

if(isset($_POST['submit'])){

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_admins = $conn->prepare("SELECT * FROM  `admins` WHERE name= ?
    LIMIT 1");
    $select_admins->execute(array($name));

    if($select_admins->rowCount() > 0){
 
        $warning_msg[] = 'Name already taken!';
        $_SESSION['warning_msg'] = $warning_msg;
    }else{
        if($pass !== $cpass){
            $warning_msg[] = 'Password not matched!';
            $_SESSION['warning_msg'] = $warning_msg;
        } else {
            $insert_admins = $conn->prepare("INSERT INTO `admins` (id, name, password) VALUES (?, ?, ?)");
            $insert_admins->execute(array($id, $name, $cpass));
            $success_msg[] = 'New Admin Registered!';
            $_SESSION['success_msg'] = $success_msg;
        }

    }
    header('Location:./register.php');
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    
<!-- header section -->
<?php require('../components/admin_header.php'); ?>



<!-- form-container section -->
<section class="form-container">

    <form action=""  method="post">
        <h3>create new accounts!</h3>
        <input type="text" name="name" class="box" placeholder="enter your name" required
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="pass" class="box" placeholder="enter your password" required
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="cpass" class="box" placeholder="confirm your password" required
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="submit" name="submit" class="btn" value="register now">
    </form>

</section>

<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>

</body>
</html>