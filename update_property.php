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
    
if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('Location: ./home.php');
    exit();
}

if(isset($_POST['update'])){

    $update_id = $_POST['property_id'];
    $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);

    
    $property_name = $_POST['property_name'];
    $property_name = filter_var($property_name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $deposite = $_POST['deposite'];
    $deposite = filter_var($deposite, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $offer = $_POST['offer'];
    $offer = filter_var($offer, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $furnished = $_POST['furnished'];
    $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
    $bhk = $_POST['bhk'];
    $bhk = filter_var($bhk, FILTER_SANITIZE_STRING);
    $bedroom = $_POST['bedroom'];
    $bedroom = filter_var($bedroom, FILTER_SANITIZE_STRING);
    $bathroom= $_POST['bathroom'];
    $bathroom = filter_var($bathroom, FILTER_SANITIZE_STRING);
    $balcony = $_POST['balcony'];
    $balcony = filter_var($balcony, FILTER_SANITIZE_STRING);
    $carpet = $_POST['carpet'];
    $carpet = filter_var($carpet, FILTER_SANITIZE_STRING);
    $age = $_POST['age'];
    $age = filter_var($age, FILTER_SANITIZE_STRING);
    $total_floors = $_POST['total_floors'];
    $total_floors = filter_var($total_floors, FILTER_SANITIZE_STRING);
    $room_floor = $_POST['room_floor'];
    $room_floor = filter_var($room_floor, FILTER_SANITIZE_STRING);
    $loan = $_POST['loan'];
    $loan = filter_var($loan, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    if(isset($_POST['lift'])){
        $lift = $_POST['lift'];
        $lift = filter_var($lift, FILTER_SANITIZE_STRING);
    }else{
        $lift = 'no';
    }

    if(isset($_POST['security_guard'])){
        $security_guard = $_POST['security_guard'];
        $security_guard = filter_var($security_guard, FILTER_SANITIZE_STRING);
    }else{
        $security_guard = 'no';
    }

    if(isset($_POST['play_guard'])){
        $play_guard = $_POST['play_guard'];
        $play_guard = filter_var($play_guard, FILTER_SANITIZE_STRING);
    }else{
        $play_guard = 'no';
    }

    if(isset($_POST['garden'])){
        $garden = $_POST['garden'];
        $garden = filter_var($garden, FILTER_SANITIZE_STRING);
    }else{
        $garden = 'no';
    }

    if(isset($_POST['water_supply'])){
        $water_supply = $_POST['water_supply'];
        $water_supply = filter_var($water_supply, FILTER_SANITIZE_STRING);
    }else{
        $water_supply = 'no';
    }

    if(isset($_POST['power_backup'])){
        $power_backup = $_POST['power_backup'];
        $power_backup = filter_var($power_backup, FILTER_SANITIZE_STRING);
    }else{
        $power_backup = 'no';
    }

    if(isset($_POST['parking_area'])){
        $parking_area = $_POST['parking_area'];
        $parking_area = filter_var($parking_area, FILTER_SANITIZE_STRING);
    }else{
        $parking_area = 'no';
    }

    if(isset($_POST['gym'])){
        $gym = $_POST['gym'];
        $gym = filter_var($gym, FILTER_SANITIZE_STRING);
    }else{
        $gym = 'no';
    }

    if(isset($_POST['shopping_mall'])){
        $shopping_mall = $_POST['shopping_mall'];
        $shopping_mall = filter_var($shopping_mall, FILTER_SANITIZE_STRING);
    }else{
        $shopping_mall = 'no';
    }

    if(isset($_POST['hospital'])){
        $hospital = $_POST['hospital'];
        $hospital = filter_var($hospital, FILTER_SANITIZE_STRING);
    }else{
        $hospital = 'no';
    }

    if(isset($_POST['school'])){
        $school = $_POST['school'];
        $school = filter_var($school, FILTER_SANITIZE_STRING);
    }else{
        $school = 'no';
    }

    if(isset($_POST['market_area'])){
        $market_area = $_POST['market_area'];
        $market_area = filter_var($market_area, FILTER_SANITIZE_STRING);
    }else{
        $market_area = 'no';
    }

    $old_image_01 = $_POST['old_image_01'];
    $old_image_01 = filter_var($old_image_01, FILTER_SANITIZE_STRING);
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
    $rename_image_01 = create_unique_id(). '.' .$image_01_ext;
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = './assets/uploadped_img/'. $rename_image_01;

    if(!empty($image_01)){
        if($image_01_size > 2000000){
            $warning_msg[] = 'image 01 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_property = $conn->prepare("UPDATE  `property` SET image_01= ? WHERE id= ?");
            $update_property->execute(array($rename_image_01, $update_id));
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            if($old_image_01 != ''){
                unlink('./assets/uploadped_img/'.$old_image_01);
            }

        }
    }


    $old_image_02 = $_POST['old_image_02'];
    $old_image_02 = filter_var($old_image_02, FILTER_SANITIZE_STRING);
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
    $rename_image_02 = create_unique_id(). '.' .$image_02_ext;
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = './assets/uploadped_img/'. $rename_image_02;

    if(!empty($image_02)){
        if($image_02_size > 2000000){
            $warning_msg[] = 'image 02 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_property = $conn->prepare("UPDATE  `property` SET image_02= ? WHERE id= ?");
            $update_property->execute(array($rename_image_02, $update_id));
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            if($old_image_02 != ''){
                unlink('./assets/uploadped_img/'.$old_image_02);
            }

        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $old_image_03 = filter_var($old_image_03, FILTER_SANITIZE_STRING);
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
    $rename_image_03 = create_unique_id(). '.' .$image_03_ext;
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = './assets/uploadped_img/'. $rename_image_03;

    if(!empty($image_03)){
        if($image_03_size > 2000000){
            $warning_msg[] = 'image 03 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_property = $conn->prepare("UPDATE  `property` SET image_03= ? WHERE id= ?");
            $update_property->execute(array($rename_image_03, $update_id));
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
            if($old_image_03 != ''){
                unlink('./assets/uploadped_img/'.$old_image_03);
            }

        }
    }

    $old_image_04 = $_POST['old_image_04'];
    $old_image_04 = filter_var($old_image_04, FILTER_SANITIZE_STRING);
    $image_04 = $_FILES['image_04']['name'];
    $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
    $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
    $rename_image_04 = create_unique_id(). '.' .$image_04_ext;
    $image_04_size = $_FILES['image_04']['size'];
    $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
    $image_04_folder = './assets/uploadped_img/'. $rename_image_04;

    if(!empty($image_04)){
        if($image_04_size > 2000000){
            $warning_msg[] = 'image 04 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_property = $conn->prepare("UPDATE  `property` SET image_04= ? WHERE id= ?");
            $update_property->execute(array($rename_image_04, $update_id));
            move_uploaded_file($image_04_tmp_name, $image_04_folder);
            if($old_image_04 != ''){
                unlink('./assets/uploadped_img/'.$old_image_04);
            }

        }
    }

    $old_image_05 = $_POST['old_image_05'];
    $old_image_05 = filter_var($old_image_05, FILTER_SANITIZE_STRING);
    $image_05 = $_FILES['image_05']['name'];
    $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
    $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
    $rename_image_05 = create_unique_id(). '.' .$image_05_ext;
    $image_05_size = $_FILES['image_05']['size'];
    $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
    $image_05_folder = './assets/uploadped_img/'. $rename_image_05;

    if(!empty($image_05)){
        if($image_05_size > 2000000){
            $warning_msg[] = 'image 05 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $update_property = $conn->prepare("UPDATE  `property` SET image_05= ? WHERE id= ?");
            $update_property->execute(array($rename_image_05, $update_id));
            move_uploaded_file($image_05_tmp_name, $image_05_folder);
            if($old_image_05 != ''){
                unlink('./assets/uploadped_img/'.$old_image_05);
            }

        }
    }

    $update_property = $conn->prepare("UPDATE `property` SET property_name=?, address=?,
    price=?, type=?, offer=?, status=?, furnished=?, bhk=?, deposite=?, bedroom=?, bathroom=?,balcony=?, carpet=?, age=?,
    total_floors=?, room_floor=?, loan=?, lift=?, security_guard=?, play_ground=?, garden=?, water_supply=?, power_backup=?,
    parking_area=?, gym=?, shopping_mall=?, hospital=?, school=?, market_area=?, description=? WHERE id=?");
   $update_property->execute(array($property_name, $address, $price, $type, $offer, $status, $furnished,
   $bhk, $deposite, $bedroom, $bathroom, $balcony, $carpet, $age, $total_floors, $room_floor, $loan, $lift, $security_guard,
   $play_guard, $garden, $water_supply, $power_backup, $parking_area, $gym, $shopping_mall, $hospital, 
   $school, $market_area, $description, $update_id));
   $success_msg[] = 'listing updated!';
   $_SESSION['success_msg'] = $success_msg;
    header('Location: ./update_property.php?get_id='. $update_id);
    exit();
}

if(isset($_POST['delete_image_02'])){

    $old_image_02 = $_POST['old_image_02'];
    $old_image_02 = filter_var($old_image_02, FILTER_SANITIZE_STRING);

    $update_property = $conn->prepare("UPDATE  `property` SET image_02= ? WHERE id= ?");
    $update_property->execute(array('', $get_id));
    if($old_image_02 != ''){
        unlink('./assets/uploadped_img/'.$old_image_02);
        $success_msg[] = 'image 02 deleted!';
        $_SESSION['success_msg'] = $success_msg;
         header('Location: ./update_property.php?get_id='. $get_id);
         exit();
    }
}

if(isset($_POST['delete_image_03'])){

    $old_image_03 = $_POST['old_image_03'];
    $old_image_03 = filter_var($old_image_03, FILTER_SANITIZE_STRING);

    $update_property = $conn->prepare("UPDATE  `property` SET image_03= ? WHERE id= ?");
    $update_property->execute(array('', $get_id));
    if($old_image_03 != ''){
        unlink('./assets/uploadped_img/'.$old_image_03);
        $success_msg[] = 'image 03 deleted!';
        $_SESSION['success_msg'] = $success_msg;
         header('Location: ./update_property.php?get_id='. $get_id);
         exit();
    }
}

if(isset($_POST['delete_image_04'])){

    $old_image_04 = $_POST['old_image_04'];
    $old_image_04 = filter_var($old_image_04, FILTER_SANITIZE_STRING);

    $update_property = $conn->prepare("UPDATE  `property` SET image_04= ? WHERE id= ?");
    $update_property->execute(array('', $get_id));
    if($old_image_04 != ''){
        unlink('./assets/uploadped_img/'.$old_image_04);
        $success_msg[] = 'image 04 deleted!';
        $_SESSION['success_msg'] = $success_msg;
         header('Location: ./update_property.php?get_id='. $get_id);
         exit();
    }
}

if(isset($_POST['delete_image_05'])){

    $old_image_05 = $_POST['old_image_05'];
    $old_image_05 = filter_var($old_image_05, FILTER_SANITIZE_STRING);

    $update_property = $conn->prepare("UPDATE  `property` SET image_05= ? WHERE id= ?");
    $update_property->execute(array('', $get_id));
    if($old_image_05 != ''){
        unlink('./assets/uploadped_img/'.$old_image_05);
        $success_msg[] = 'image 05 deleted!';
        $_SESSION['success_msg'] = $success_msg;
         header('Location: ./update_property.php?get_id='. $get_id);
         exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update property</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- property-form section -->

<section class="property-form">

    <?php 
    $select_property = $conn->prepare("SELECT * FROM  `property` WHERE id= ? LIMIT 1 ");
    $select_property->execute(array($get_id));
    if($select_property->rowCount() > 0){
        while($fetch_property = $select_property->fetch(PDO::FETCH_ASSOC)){

        $property_id = $fetch_property['id'];   
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <h3>property details</h3>
        <input type="hidden" name="property_id" value="<?= $property_id ?>">
        <input type="hidden" name="old_image_01" value="<?= $fetch_property['image_01']; ?>">
        <input type="hidden" name="old_image_02" value="<?= $fetch_property['image_02']; ?>">
        <input type="hidden" name="old_image_03" value="<?= $fetch_property['image_03']; ?>">
        <input type="hidden" name="old_image_04" value="<?= $fetch_property['image_04']; ?>">
        <input type="hidden" name="old_image_05" value="<?= $fetch_property['image_05']; ?>">
        <div class="box">
            <p>property name </p>
            <input type="text" name="property_name" class="input" maxlength="50"  
           placeholder="enter property name" value="<?= $fetch_property['property_name']; ?>">
        </div>
        
        <div class="flex">

            <div class="box">
                <p>property price </p>
                <input type="number" name="price" class="input" max="9999999999" min="0" maxlength="10" 
                placeholder="enter property price" value="<?= $fetch_property['price']; ?>">
            </div>

            <div class="box">
                <p>deposite amount </p>
                <input type="number" name="deposite" class="input" max="9999999999" min="0" maxlength="10" 
                placeholder="enter deposite amount" value="<?= $fetch_property['deposite']; ?>">
            </div>

            <div class="box">
                <p>property address </p>
                <input type="text" name="address" class="input"  maxlength="100" 
                placeholder="enter property address" value="<?= $fetch_property['address']; ?>">
            </div>

            <div class="box">
                <p>offer type </p>
                <select name="offer" class="input" >
                    <option value="<?= $fetch_property['offer']; ?>" selected>
                    <?= $fetch_property['offer']; ?></option>
                    <option value="sale">sale</option>
                    <option value="resale">resale</option>
                    <option value="rent">rent</option>
                </select>
            </div>

            <div class="box">
                <p>property type </p>
                <select name="type" class="input" >
                    <option value="<?= $fetch_property['type']; ?>" selected>
                    <?= $fetch_property['type']; ?></option>
                    <option value="flat">flat</option>
                    <option value="house">house</option>
                    <option value="shop">shop</option>
                </select>
            </div>

            
            <div class="box">
                <p>property status </p>
                <select name="status" class="input" >
                    <option value="<?= $fetch_property['status']; ?>" selected>
                    <?= $fetch_property['status']; ?></option>
                    <option value="ready to move">ready to move</option>
                    <option value="under construction">under construction</option>
                </select>
            </div>
            
            <div class="box">
                <p>furnished status </p>
                <select name="furnished" class="input" >
                    <option value="<?= $fetch_property['furnished']; ?>" selected>
                    <?= $fetch_property['furnished']; ?></option>
                    <option value="unfurnished">unfurnished</option>
                    <option value="semi-furnished">semi-furnished</option>
                    <option value="furnished">furnished</option>
                </select>
            </div>
            
            <div class="box">
                <p>how may BHK </p>
                <select name="bhk" class="input" >
                    <option value="<?= $fetch_property['bhk']; ?>" selected>
                    <?= $fetch_property['bhk']; ?> BHK</option>
                    <option value="1">1 BHK</option>
                    <option value="2">2 BHK</option>
                    <option value="3">3 BHK</option>
                    <option value="4">4 BHK</option>
                    <option value="5">5 BHK</option>
                    <option value="6">6 BHK</option>
                    <option value="7">7 BHK</option>
                    <option value="8">8 BHK</option>
                    <option value="9">9 BHK</option>
                </select>
            </div>
            
            <div class="box">
                <p>how may bedrooms </p>
                <select name="bedroom" class="input" >
                    <option value="<?= $fetch_property['bedroom']; ?>" selected>
                    <?= $fetch_property['bedroom']; ?> bedroom</option>
                    <option value="1">1 bedroom</option>
                    <option value="2">2 bedrooms</option>
                    <option value="3">3 bedrooms</option>
                    <option value="4">4 bedrooms</option>
                    <option value="5">5 bedrooms</option>
                    <option value="6">6 bedrooms</option>
                    <option value="7">7 bedrooms</option>
                    <option value="8">8 bedrooms</option>
                    <option value="9">9 bedrooms</option>
                </select>
            </div>
            
            <div class="box">
                <p>how may bathrooms </p>
                <select name="bathroom" class="input" >
                    <option value="<?= $fetch_property['bathroom']; ?>" selected>
                    <?= $fetch_property['bathroom']; ?> bathroom</option>
                    <option value="1">1 bathroom</option>
                    <option value="2">2 bathrooms</option>
                    <option value="3">3 bathrooms</option>
                    <option value="4">4 bathrooms</option>
                    <option value="5">5 bathrooms</option>
                    <option value="6">6 bathrooms</option>
                    <option value="7">7 bathrooms</option>
                    <option value="8">8 bathrooms</option>
                    <option value="9">9 bathrooms</option>
                </select>
            </div>
            
            <div class="box">
                <p>how may balconys </p>
                <select name="balcony" class="input" >
                    <option value="<?= $fetch_property['balcony']; ?>" selected>
                    <?= $fetch_property['balcony']; ?> balcony</option>
                    <option value="0">0 balcony</option>
                    <option value="1">1 balcony</option>
                    <option value="2">2 balconys</option>
                    <option value="3">3 balconys</option>
                    <option value="4">4 balconys</option>
                    <option value="5">5 balconys</option>
                    <option value="6">6 balconys</option>
                    <option value="7">7 balconys</option>
                    <option value="8">8 balconys</option>
                    <option value="9">9 balconys</option>
                </select>
            </div>

            <div class="box">
                <p>carpet area (sqft) </p>
                <input type="number" name="carpet" class="input" max="9999999999" min="0" maxlength="10" 
                placeholder="how may squarefits" value="<?= $fetch_property['carpet']; ?>">
            </div>
            
            <div class="box">
                <p>property age </p>
                <input type="number" name="age" class="input" max="99" min="0" maxlength="2" 
                placeholder="how old is property" value="<?= $fetch_property['age']; ?>">
            </div>
            
            
            <div class="box">
                <p>total floors </p>
                <input type="number" name="total_floors" class="input" max="99" min="0" maxlength="2" 
                placeholder="how many floors available?" value="<?= $fetch_property['total_floors']; ?>">
            </div>

            <div class="box">
                <p>room floors </p>
                <input type="number" name="room_floor" class="input" max="99" min="0" maxlength="2" 
                placeholder="property floor number" value="<?= $fetch_property['room_floor']; ?>">
            </div>
            

            
            <div class="box">
                <p>loan </p>
                <select name="loan" class="input" >
                    <option value="<?= $fetch_property['loan']; ?>" selected>
                    <?= $fetch_property['loan']; ?></option>
                    <option value="available">available</option>
                    <option value="not available">not available</option>
                </select>
            </div>
            
            <div class="box">
                <p>property description </p>
                    <textarea name="description" class="input" cols="30" rows="10" maxlength="1000"
                     placeholder="enter property description"><?= $fetch_property['description']; ?></textarea>
            </div>
        </div>

        <div class="checkbox">
            <div class="box">
                <label><input type="checkbox" name="lift" value="yes" <?php if($fetch_property['lift'] == 'yes')echo 'checked'; ?>>lifts</label>
                <label><input type="checkbox" name="security_guard" value="yes"  <?php if($fetch_property['security_guard'] == 'yes')echo 'checked'; ?>>security guard</label>
                <label><input type="checkbox" name="play_ground" value="yes"  <?php if($fetch_property['play_ground'] == 'yes')echo 'checked'; ?>>play ground</label>
                <label><input type="checkbox" name="garden" value="yes"  <?php if($fetch_property['garden'] == 'yes')echo 'checked'; ?>>garden</label>
                <label><input type="checkbox" name="water_supply" value="yes"  <?php if($fetch_property['water_supply'] == 'yes')echo 'checked'; ?>>water supply</label>
                <label><input type="checkbox" name="power_backup" value="yes"  <?php if($fetch_property['power_backup'] == 'yes')echo 'checked'; ?>>power backup</label>
            </div>

            <div class="box">
                <label><input type="checkbox" name="parking_area" value="yes" <?php if($fetch_property['parking_area'] == 'yes')echo 'checked'; ?>>parking area</label>
                <label><input type="checkbox" name="gym" value="yes" <?php if($fetch_property['gym'] == 'yes')echo 'checked'; ?>>gym</label>
                <label><input type="checkbox" name="shopping_mall" value="yes" <?php if($fetch_property['shopping_mall'] == 'yes')echo 'checked'; ?>>shopping_mall</label>
                <label><input type="checkbox" name="hospital" value="yes" <?php if($fetch_property['hospital'] == 'yes')echo 'checked'; ?>>hospital</label>
                <label><input type="checkbox" name="school" value="yes" <?php if($fetch_property['school'] == 'yes')echo 'checked'; ?>>school</label>
                <label><input type="checkbox" name="market_area" value="yes" <?php if($fetch_property['market_area'] == 'yes')echo 'checked'; ?>>market area</label>
            </div>
        </div>

        <div class="box">
            <img src="./assets/uploadped_img/<?= $fetch_property['image_01']; ?>" alt="">
            <p>update image 01 </p>
            <input type="file" name="image_01" class="input" accept="image/*">
        </div>

        <div class="flex">

            <div class="box">
                <?php 
                    if(!empty($fetch_property['image_02'])){
                ?>
                
                    <img src="./assets/uploadped_img/<?= $fetch_property['image_02']; ?>" alt="">
                    <input type="submit" name="delete_image_02" value="delete image 02"
                     class="btn" onclick="return confirm('delete image 02?');">
                <?php 
                }
                ?>
                <p>update image 02</p>
                <input type="file" name="image_02" class="input" accept="image/*">
            </div>

            <div class="box">
                <?php 
                    if(!empty($fetch_property['image_03'])){
                ?>
                
                    <img src="./assets/uploadped_img/<?= $fetch_property['image_03']; ?>" alt="">
                    <input type="submit" name="delete_image_03" value="delete image 03"
                     class="btn" onclick="return confirm('delete image 03?');">
                <?php 
                }
                ?>
                <p>update image 03</p>
                <input type="file" name="image_03" class="input" accept="image/*">
            </div>

            <div class="box">
                <?php 
                    if(!empty($fetch_property['image_04'])){
                ?>
                
                    <img src="./assets/uploadped_img/<?= $fetch_property['image_04']; ?>" alt="">
                    <input type="submit" name="delete_image_04" value="delete image 04"
                     class="btn" onclick="return confirm('delete image 04?');">
                <?php 
                }
                ?>
                <p>update image 04</p>
                <input type="file" name="image_04" class="input" accept="image/*">
            </div>

            <div class="box">
                <?php 
                    if(!empty($fetch_property['image_05'])){
                ?>
                
                    <img src="./assets/uploadped_img/<?= $fetch_property['image_05']; ?>" alt="">
                    <input type="submit" name="delete_image_05" value="delete image 05"
                     class="btn" onclick="return confirm('delete image 05?');">
                <?php 
                }
                ?>
                <p>update image 05</p>
                <input type="file" name="image_05" class="input" accept="image/*">
            </div>

        </div>
            <input type="submit" value="update property" name="update" class="btn">
    </form>

    <?php 
                    
    }
    }else{
        echo '<p class="empty">property was not found!</p>';
    }

    ?>
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
