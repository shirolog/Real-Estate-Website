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

if(isset($_POST['delete'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    
    $select_messages = $conn->prepare("SELECT * FROM `messages` WHERE id= ?");
    $select_messages->execute(array($delete_id));

    if($select_messages->rowCount() > 0){

        $delete_messages = $conn->prepare("DELETE FROM  `messages` WHERE id= ?");
        $delete_messages->execute(array($delete_id));
        $success_msg[] = 'Message deleted!';
        $_SESSION['success_msg'] = $success_msg;
    }else{
        $warning_msg[] = 'Message deleted already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    
    if($_POST['search_box'] != ''){
        setcookie('message', 1, time() + 30 * 60, '/');
    }
    header('Location:./message.php');
    exit();
}



if(isset($_COOKIE['message'])){
    $_POST['search_box'] = $_COOKIE['search_message'];
    $_POST['search_btn'] = '';
    setcookie('message', '', time() - 1, '/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    
<!-- header section -->
<?php require('../components/admin_header.php'); ?>

<!-- grid section -->
<section class="grid">

    <h1 class="heading">messages</h1>

    <form action="" method="post" class="search-form">
        <input type="text" name="search_box" placeholder="search listings..." maxlength="100"
        required>
        <button type="submit" name="search_btn" class="fas fa-search"></button>
    </form>

    <div class="box-container">

    <?php 
        if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){

            $search_box = $_POST['search_box'];
            $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);

            
            $select_messages = $conn->prepare("SELECT * FROM `messages` WHERE name
            LIKE '%{$search_box}%' OR email LIKE '%{$search_box}%' OR number LIKE '%{$search_box}%'");
            $select_messages->execute();

            setcookie('search_message', $search_box, time() + 60 * 30, '/');

        }else{
            $search_box = '';
            
            
            $select_messages = $conn->prepare("SELECT * FROM  `messages` ");
            $select_messages->execute();   
        }    
        if($select_messages->rowCount() > 0){
            while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
    ?>

        <div class="box">
            <p>name : <span><?= $fetch_messages['name']; ?></span></p>
            <p>email : <a href="mailto:<?= $fetch_messages['email']; ?>"><?= $fetch_messages['email']; ?></a></p>
            <p>number : <a href="tel:<?= $fetch_messages['number']; ?>"><?= $fetch_messages['number']; ?></a></p>
            <p>message : <span><?= $fetch_messages['message']; ?></span></p>
            <form action="" method="post">
                <input type="hidden" name="search_box", value="<?= $search_box; ?>">
                <input type="hidden" name="delete_id" value="<?= $fetch_messages['id']; ?>">
                <input type="submit" name="delete" class="delete-btn" value="delete message"
                onclick="return confirm('delete this message?');">
            </form>
        </div>

    <?php 
    }
    }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
        echo '<p class="empty">no result found!</p>';
    }else{
        echo '<p class="empty">you have no messages!</p>';
    }
    ?>


    </div>

</section>


<!-- sweetalert.js cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js -->
<script src="../js/admin.js"></script>

<?php  require('../components/message.php'); ?>


</body>
</html>

