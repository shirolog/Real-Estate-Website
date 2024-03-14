<?php 
require('../components/connect.php');
session_start();


if(isset($_COOKIE['admin_id'])){
    $admin_id = $_COOKIE['admin_id'];
}else{
   setcookie('admin_id', $admin_id, time() - 1, '/');
    header('Location: ../admin/login.php');
    exit();
}

if(isset($_POST['delete'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    
    $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE id= ? LIMIT 1");
    $select_admins->execute(array($delete_id));

    if($select_admins->rowCount() > 0){
        $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id= ?");
        $delete_admins->execute(array($delete_id));
        $success_msg[] = 'Admin deleted';
        $_SESSION['success_msg'] = $success_msg;
    }else{
        $warning_msg[] = 'Admin deleted already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    if($_POST['search_box'] != ''){
        setcookie('admin', 1, time() + 60 * 30, '/');
    }
    header('Location:./admins.php');
    exit();
}

if(isset($_COOKIE['admin'])){

    $_POST['search_box'] = $_COOKIE['search_admin'];
    $_POST['search_btn'] = '';
    setcookie('admin', '', time() - 1, '/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins</title>

    
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

    <h1 class="heading">admins account</h1>

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

            
            $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name
            LIKE '%{$search_box}%'");
            $select_admins->execute();
            
            setcookie('search_admin', $search_box, time() + 60* 30, '/');
            
        }else{
            
            $search_box = '';

            $select_admins = $conn->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
        }
            if($select_admins->rowCount() > 0){
                while($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)){                          
    ?>

        <?php 
            if($fetch_admins['id'] == $admin_id){
        ?>

            <div class="box" style="order: -1;">
                <p>name : <span><?= $fetch_admins['name']; ?></span></p>
                <div class="flex-btn">
                    <a href="./update.php" class="btn">update</a>
                    <a href="./register.php" class="option-btn">register</a>
                </div>
            </div>

        <?php 
        }else{
        ?>

            <div class="box">
                <p>name : <span><?= $fetch_admins['name']; ?></span></p>
                <form action="" method="post">
                    <input type="hidden" name="search_box" value="<?= $search_box; ?>">
                    <input type="hidden" name="delete_id" value="<?=$fetch_admins['id']; ?>">
                    <input type="submit" name="delete" class="delete-btn" value="delete admin"
                    onclick="return confirm('delete this admin?');">
                </form>
            </div>

        <?php
        }
        ?>
    <?php 
        }
        }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
            echo '<p class="empty">no result found!</p>';
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