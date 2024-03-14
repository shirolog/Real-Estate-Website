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

if(isset($_POST['send'])){

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_messages = $conn->prepare("SELECT * FROM `messages` WHERE name= ? AND email= ? AND number= ? AND
    message= ?");
    $select_messages->execute(array($name, $email, $number, $msg));
    if($select_messages->rowCount() > 0){
        $warning_msg[] = 'message sent already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }else{
        $insert_messages = $conn->prepare("INSERT INTO `messages` (id, name, email, number, message) VALUES
        (?, ?, ?, ?, ?)");
        $insert_messages->execute(array($id, $name, $email, $number, $msg));
        $success_msg[] = 'message sent successfully!';
        $_SESSION['success_msg'] = $success_msg;
    }
    header('Location:./contact.php');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- contact section -->
<section class="contact">

    <div class="row">
        <div class="image">
            <img src="./assets/images/contact-img.svg" alt="">
        </div>
        <form action="" method="post">
            <h3>get in touch</h3>
            <input type="text" name="name" class="box" placeholder="enter your name"
            required maxlength="50">
            <input type="email" name="email" class="box" placeholder="enter your email"
            required maxlength="50">
            <input type="number" name="number" class="box" placeholder="enter your number"
            required max="9999999999" min="0">
            <textarea name="msg" class="box" placeholder="enter your message"
             cols="30" rows="10" maxlength="1000" required></textarea>
             <input type="submit" name="send" value="send message" class="inline-btn">
        </form>
    </div>

</section>

<!-- faq section -->
<section class="faq" id="faq">

    <h1 class="heading">FAQ</h1>

    <div class="box-container">

        <div class="box active">
            <h3>how to cancel booking?<i class="fas fa-angle-down active"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
        </div>

        
        <div class="box active">
            <h3>when will I get the possession?<i class="fas fa-angle-down active"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
        </div>

        <div class="box">
            <h3>where can I play the rent?<i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
        </div>

        <div class="box">
            <h3>how to contact with the buyers?<i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
        </div>

        <div class="box">
            <h3>why my listing not showing up?<i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
        </div>


        <div class="box">
            <h3>how to promote my listing?<i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ipsam quos suscipit velit excepturi aut vero ipsum earum natus 
            laboriosam debitis.</p>
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