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


if(isset($_POST['save'])){

    if($user_id != ''){
        $save_id = create_unique_id();
        $poperty_id = $_POST['property_id'];
        $poperty_id = filter_var($poperty_id, FILTER_SANITIZE_STRING);
        
        $select_saved =$conn->prepare("SELECT * FROM  `saved` WHERE property_id= ? AND
        user_id= ?");
        $select_saved->execute(array($poperty_id, $user_id));
        if($select_saved->rowCount() > 0){
            $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id= ? AND user_id= ?");
            $delete_saved->execute(array($poperty_id, $user_id));
            $success_msg[]= 'Remove from saved!';
            $_SESSION['success_msg'] = $success_msg;    
        }else{
            $insert_saved = $conn->prepare("INSERT INTO `saved`(id, property_id, user_id) VALUES(?, ?, ?)");
            $insert_saved->execute(array($save_id, $poperty_id, $user_id));
            $success_msg[]= 'Added to saved!';
            $_SESSION['success_msg'] = $success_msg;  
        }
       

    }else{
        $warning_msg[]= 'Please login first!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location: ./home.php');
    exit();
}



if(isset($_POST['send'])){

    if($user_id != ''){
        $send_id = create_unique_id();
        $poperty_id = $_POST['property_id'];
        $poperty_id = filter_var($poperty_id, FILTER_SANITIZE_STRING);
        

        $select_property = $conn->prepare("SELECT * FROM `property` WHERE id=? 
        LIMIT 1");
        $select_property->execute(array($poperty_id));
        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
        $receiver = $fetch_property['user_id'];

        $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE property_id= ? AND
        sender= ?");
        $select_requests->execute(array($poperty_id, $user_id));
        if($select_requests->rowCount() > 0){
            $warning_msg[]= 'Request sent already!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $insert_requests= $conn->prepare("INSERT INTO `requests` (id, property_id, sender, receiver) VALUES
            (?, ?, ?, ?) ");
            $insert_requests->execute(array($send_id, $poperty_id, $user_id, $receiver));
            $success_msg[]= 'Request sent successfully!';
            $_SESSION['success_msg'] = $success_msg;  
        }
    }else{
        $warning_msg[]= 'Please login first!';
        $_SESSION['warning_msg'] = $warning_msg;
    }
    header('Location: ./home.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- home section -->
<section class="home">

    <div class="center">
        <form action="search.php" method="post">
            <h3>find your perfect home</h3>
            <div class="box">
                <p>enter location <span>*</span></p>
                <input type="text" name="address" class="input" required maxlength="50"
                placeholder="enter city name">
            </div>

            <div class="flex">
                <div class="box">
                    <p>property type <span>*</span></p>
                    <select name="type" class="input" required>
                        <option value="flat">flat</option>
                        <option value="house">house</option>
                        <option value="shop">shop</option>
                    </select>
                </div>
                
                <div class="box">
                    <p>offer type <span>*</span></p>
                    <select name="offer" class="input" required>
                        <option value="sale">sale</option>
                        <option value="resale">resale</option>
                        <option value="rent">rent</option>
                    </select>
                </div>

                <div class="box">
                    <p>minimum budget <span>*</span></p>
                    <select name="min" class="input" required>
                        <option value="5000">5k</option>
                        <option value="10000">10k</option>
                        <option value="15000">15k</option>
                        <option value="20000">20k</option>
                        <option value="30000">30k</option>
                        <option value="40000">40k</option>
                        <option value="40000">40k</option>
                        <option value="50000">50k</option>
                        <option value="100000">1 lac</option>
                        <option value="500000">5 lac</option>
                        <option value="1000000">10 lac</option>
                        <option value="2000000">20 lac</option>
                        <option value="3000000">30 lac</option>
                        <option value="4000000">40 lac</option>
                        <option value="4000000">40 lac</option>
                        <option value="5000000">50 lac</option>
                        <option value="6000000">60 lac</option>
                        <option value="7000000">70 lac</option>
                        <option value="8000000">80 lac</option>
                        <option value="9000000">90 lac</option>
                        <option value="10000000">1 Cr</option>
                        <option value="20000000">2 Cr</option>
                        <option value="30000000">3 Cr</option>
                        <option value="40000000">4 Cr</option>
                        <option value="50000000">5 Cr</option>
                        <option value="60000000">6 Cr</option>
                        <option value="70000000">7 Cr</option>
                        <option value="80000000">8 Cr</option>
                        <option value="90000000">9 Cr</option>
                        <option value="100000000">10 Cr</option>
                        <option value="150000000">15 Cr</option>
                        <option value="200000000">20 Cr</option>
                    </select>
                </div>

                <div class="box">
                    <p>maximum budget <span>*</span></p>
                    <select name="max" class="input" required>
                        <option value="5000">5k</option>
                        <option value="10000">10k</option>
                        <option value="15000">15k</option>
                        <option value="20000">20k</option>
                        <option value="30000">30k</option>
                        <option value="40000">40k</option>
                        <option value="40000">40k</option>
                        <option value="50000">50k</option>
                        <option value="100000">1 lac</option>
                        <option value="500000">5 lac</option>
                        <option value="1000000">10 lac</option>
                        <option value="2000000">20 lac</option>
                        <option value="3000000">30 lac</option>
                        <option value="4000000">40 lac</option>
                        <option value="4000000">40 lac</option>
                        <option value="5000000">50 lac</option>
                        <option value="6000000">60 lac</option>
                        <option value="7000000">70 lac</option>
                        <option value="8000000">80 lac</option>
                        <option value="9000000">90 lac</option>
                        <option value="10000000">1 Cr</option>
                        <option value="20000000">2 Cr</option>
                        <option value="30000000">3 Cr</option>
                        <option value="40000000">4 Cr</option>
                        <option value="50000000">5 Cr</option>
                        <option value="60000000">6 Cr</option>
                        <option value="70000000">7 Cr</option>
                        <option value="80000000">8 Cr</option>
                        <option value="90000000">9 Cr</option>
                        <option value="100000000">10 Cr</option>
                        <option value="150000000">15 Cr</option>
                        <option value="200000000">20 Cr</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="search property" name="search" class="btn">
        </form>
    </div>
</section>


<!-- services section -->
<section class="services">

    <h1 class="heading">our services</h1>

    <div class="box-container">

        <div class="box">
            <img src="./assets/images/icon-1.png" alt="">
            <h3>buy house</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

        <div class="box">
            <img src="./assets/images/icon-2.png" alt="">
            <h3>rent house</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

        <div class="box">
            <img src="./assets/images/icon-3.png" alt="">
            <h3>sell house</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

        <div class="box">
            <img src="./assets/images/icon-4.png" alt="">
            <h3>flats and buildings</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

        <div class="box">
            <img src="./assets/images/icon-5.png" alt="">
            <h3>shops and malls</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

        <div class="box">
            <img src="./assets/images/icon-6.png" alt="">
            <h3>24/7 service</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
            Quas, nulla.</p>
        </div>

    </div>

</section>

<!-- listings section -->
<section class="listings">

    <h1 class="heading">latest listings</h1>

    <div class="box-container">
    
        <?php 
            $select_property = $conn->prepare("SELECT * FROM `property`  ORDER BY date DESC
            LIMIT 6");
            $select_property->execute();
            if($select_property->rowCount() > 0){

                while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_property['id'];

                
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE id= ?");
                $select_users->execute(array($user_id));
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

                if(!empty($fetch_property['image_02'])){
                    $count_image_02 = 1;
                }else{
                    $count_image_02 = 0;
                }

                if(!empty($fetch_property['image_03'])){
                    $count_image_03 = 1;
                }else{
                    $count_image_03 = 0;
                }

                if(!empty($fetch_property['image_04'])){
                    $count_image_04 = 1;
                }else{
                    $count_image_04 = 0;
                }

                if(!empty($fetch_property['image_05'])){
                    $count_image_05 = 1;
                }else{
                    $count_image_05 = 0;
                }
                
                $total_images = (1 + $count_image_02 + 
                $count_image_03 + $count_image_04 + $count_image_05);

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id= ? AND user_id= ?");
                $select_saved->execute(array($property_id, $user_id));
        ?>
           <form action="" method="post">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="./assets/uploadped_img/<?= $fetch_property['image_01']; ?> ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_users['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_users['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-dollar-sign"></i><span><?= number_format($fetch_property['price']); ?></span> /-</div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
            <?php 
            }
            }else{
                echo '<p class="empty">no property listed yet!</p>';
            }
            ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">
        <a href="./listings.php" class="inline-btn">view all</a>
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
