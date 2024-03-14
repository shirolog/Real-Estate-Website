<?php 
require('./assets/components/connect.php');
session_start();


if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];

}else{
    setcookie('user_id', '', time() - 1, '/');
    header('Location: login.php');
    exit();
}

$select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ? LIMIT 1 ");
$select_users->execute(array($user_id));
$fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    if(!empty($name)){

        $update_users = $conn->prepare("UPDATE `users` SET name=? WHERE id= ?");
        $update_users->execute(array($name, $user_id));
        $success_msg[] = 'name updated!';
        $_SESSION['success_msg'] = $success_msg;
    }

    if(!empty($number)){

        $update_users = $conn->prepare("UPDATE `users` SET number=? WHERE id= ?");
        $update_users->execute(array($number, $user_id));
        $success_msg[] = 'number updated!';
        $_SESSION['success_msg'] = $success_msg;
    }

    if(!empty($email)){
        $select_users= $conn->prepare("SELECT email FROM `users` WHERE email= ? ");
        $select_users->execute(array($email));
        if($select_users->rowCount() > 0){
            $warning_msg[] = 'email already taken!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_users = $conn->prepare("UPDATE `users` SET email=? WHERE id= ?");
            $update_users->execute(array($email, $user_id));
            $success_msg[] = 'email updated!';
            $_SESSION['success_msg'] = $success_msg;
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_users['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    if($empty_pass != $old_pass){
        if($old_pass != $prev_pass){
            $warning_msg[] = 'old password not matched!!';
            $_SESSION['warning_msg'] = $warning_msg;
        }elseif($new_pass != $cpass){
            $warning_msg[] = 'confirm password not matched!!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            if($new_pass != $empty_pass){
                $update_users = $conn->prepare("UPDATE `users` SET password= ? WHERE id= ?");
                $update_users->execute(array($cpass, $user_id));
                $success_msg[] = 'password updated!';
                $_SESSION['success_msg'] = $success_msg;
            }else{
                $warning_msg[] = 'please enter new password!!';
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
    <title>Update</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    
<!-- header section -->
<?php require('./assets/components/user_header.php'); ?>


<!-- form-container section -->
<section class="form-container" style="min-height: auto;">

    <form action="" method="post">
        <h3>update your account</h3>
        <input type="text" name="name" class="box" 
        placeholder="<?= $fetch_users['name']; ?>" maxlength="50">
        <input type="email" name="email" class="box" 
        placeholder="<?= $fetch_users['email']; ?>" maxlength="50">
        <input type="number" name="number" class="box" 
        placeholder="<?= $fetch_users['number']; ?>" min="0" max="9999999999" maxlength="10">
        <input type="password" name="old_pass" class="box" 
        placeholder="enter your old password" maxlength="20">
        <input type="password" name="new_pass" class="box" 
        placeholder="enter your new password" maxlength="20">
        <input type="password" name="cpass" class="box" 
        placeholder="confirm your new password" maxlength="20">
        <input type="submit" name="submit" class="btn" value="update now">
    </form>

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