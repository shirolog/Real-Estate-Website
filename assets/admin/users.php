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

    $select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ? LIMIT 1");
    $select_users->execute(array($delete_id));
    if($select_users->rowCount() > 0){

        $select_property = $conn->prepare("SELECT * FROM   `property` WHERE user_id= ?");
        $select_property->execute(array($delete_id));
        while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){
            $delete_image_01 = $fetch_property['image_01'];
            $delete_image_02 = $fetch_property['image_02'];
            $delete_image_03 = $fetch_property['image_03'];
            $delete_image_04 = $fetch_property['image_04'];
            $delete_image_05 = $fetch_property['image_05'];

            unlink('../uploadped_img/'. $delete_image_01);

            if(!empty($fetch_property['image_02'])){
                unlink('../uploadped_img/'. $delete_image_02);
            }

            if(!empty($fetch_property['image_03'])){
                unlink('../uploadped_img/'. $delete_image_03);
            }

            if(!empty($fetch_property['image_04'])){
                unlink('../uploadped_img/'. $delete_image_04);
            }

            if(!empty($fetch_property['image_05'])){
                unlink('../uploadped_img/'. $delete_image_05);
            }
        }

        $delete_property = $conn->prepare("DELETE FROM `property` WHERE user_id= ?");
        $delete_property->execute(array($delete_id));

        $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE user_id= ?");
        $delete_saved->execute(array($delete_id));

        $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE sender= ? OR receiver= ?");
        $delete_requests->execute(array($delete_id, $delete_id));

        $delete_users = $conn->prepare("DELETE FROM `users` WHERE id= ?");
        $delete_users->execute(array($delete_id));
        $success_msg[] = 'User deleted!';
        $_SESSION['success_msg'] = $success_msg;

    }else{
        $warning_msg[] = 'User deleted already!';
        $_SESSION['warning_msg'] = $warning_msg;
    }

    if($_POST['search_box'] != ''){
        setcookie('search', 1, time() + 60 * 30, '/');
    }
    header('Location:./users.php');
    exit();
}

if(isset($_COOKIE['search'])){
    $_POST['search_box'] = $_COOKIE['search_user'];
    $_POST['search_btn'] = '';
    setcookie('search', '', time() - 1, '/');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>

    
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

    <h1 class="heading">users account</h1>

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

            
            $select_users = $conn->prepare("SELECT * FROM `users` WHERE name
            LIKE '%{$search_box}%' OR email LIKE '%{$search_box}%' OR number LIKE '%{$search_box}%'");
            $select_users->execute();
            
            setcookie('search_user', $search_box, time() + 60* 30, '/');
            
        }else{
            
            $search_box = '';

            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
        }
            if($select_users->rowCount() > 0){
                while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){           
            
                $select_property = $conn->prepare("SELECT * FROM `property` WHERE user_id = ? ");
                $select_property->execute(array($fetch_users['id']));
                $total_property = $select_property->rowCount();                
    ?>

            <div class="box">
                <p>name : <span><?= $fetch_users['name']; ?></span></p>
                <p>email : <a href="<?= $fetch_users['email']; ?>"><?= $fetch_users['email']; ?></a></p>
                <p>number : <a href="<?= $fetch_users['number']; ?>"><?= $fetch_users['number']; ?></a></p>
                <p>property listited : <span><?= $total_property; ?></span></p>
                <form action="" method="post">
                    <input type="hidden" name="search_box" value="<?= $search_box; ?>">
                    <input type="hidden" name="delete_id" value="<?= $fetch_users['id']; ?>">
                    <input type="submit" name="delete" class="delete-btn" value="delete user" 
                    onclick="return confirm('delete this user?');">
                </form>
            </div>
    <?php 
        }
        }elseif(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
    

            echo '<p class="empty">no result found!</p>';
  
          
        }else{
      
  
            echo '<p class="empty">no users yet!</p>';
  
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