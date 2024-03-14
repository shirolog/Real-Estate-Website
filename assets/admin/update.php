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

$select_admins = $conn->prepare("SELECT * FROM  `admins` WHERE id= ? LIMIT 1");
$select_admins->execute(array($admin_id));
$fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    if(!empty($name)){
        $select_admins = $conn->prepare("SELECT * FROM  `admins` WHERE name= ?
        LIMIT 1");
        $select_admins->execute(array($name));
        if($select_admins->rowCount() > 0){
            $warning_msg[] = 'Name already taken! ';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
    
            $update_admins = $conn->prepare("UPDATE  `admins` SET name= ? WHERE id= ?");
            $update_admins->execute(array($name, $admin_id));
            $success_msg[] = 'Name updated!';
            $_SESSION['success_msg'] = $success_msg;
        }
    }


    $prev_pass = $fetch_admins['password'];
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $warning_msg[] = 'Old password not matched!';
            $_SESSION['warning_msg'] = $warning_msg;
        }elseif($new_pass != $cpass){
            $warning_msg[] = 'Confirm password not matched!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            if($new_pass != $empty_pass){
                $upadate_admins = $conn->prepare("UPDATE `admins` SET password= ?
                WHERE id= ?");
                $upadate_admins->execute(array($cpass, $admin_id));
                $success_msg[] = 'Password updated!';
                $_SESSION['success_msg'] = $success_msg;
            }else{
                $warning_msg[] = 'Please enter new password!!';
                $_SESSION['warning_msg'] = $warning_msg;
            }
        }
    }


    header('Location:./update.php');
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>

    
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
        <h3>update profile</h3>
        <input type="text" name="name" class="box" placeholder="<?= $fetch_admins['name']; ?>" 
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="old_pass" class="box" placeholder="enter your old password" 
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="new_pass" class="box" placeholder="enter your new password" 
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="password" name="cpass" class="box" placeholder="confirm your password" 
        oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20">
        <input type="submit" name="submit" class="btn" value="update now">
    </form>

</section>

<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>
</body>
</html>