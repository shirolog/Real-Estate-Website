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

if(isset($_POST['post'])){

    $id = create_unique_id();

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

    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
    $rename_image_01 = create_unique_id(). '.' .$image_01_ext;
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = './assets/uploadped_img/'. $rename_image_01;


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
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
        }
    }else{
        $rename_image_02 = '';
    }

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
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
        }
    }else{
        $rename_image_03 = '';
    }

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
            move_uploaded_file($image_04_tmp_name, $image_04_folder);
        }
    }else{
        $rename_image_04 = '';
    }

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
            move_uploaded_file($image_05_tmp_name, $image_05_folder);
        }
    }else{
        $rename_image_05 = '';
    }


        if($image_01_size > 2000000){
            $warning_msg[] = 'image 01 size is too large!';
            $_SESSION['warning_msg'] = $warning_msg;
        }else{
            $insert_property = $conn->prepare("INSERT INTO `property` (id, user_id, property_name, address,
            price, type, offer, status, furnished, bhk, deposite, bedroom, bathroom,balcony, carpet, age,
            total_floors, room_floor, loan, lift, security_guard, play_ground, garden, water_supply, power_backup,
            parking_area, gym, shopping_mall, hospital, school, market_area, image_01, image_02, image_03,
           image_04, image_05, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
            $insert_property->execute(array($id, $user_id, $property_name, $address, $price, $type, $offer, $status, $furnished,
            $bhk, $deposite, $bedroom, $bathroom, $balcony, $carpet, $age, $total_floors, $room_floor, $loan, $lift, $security_guard,
            $play_guard, $garden, $water_supply, $power_backup, $parking_area, $gym, $shopping_mall, $hospital, $school, $market_area,
            $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description));
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            $success_msg[] = 'property posted!';
            $_SESSION['success_msg'] = $success_msg;
        }
    header('Location: ./post_property.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>post property</title>

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

    <form action="" method="post" enctype="multipart/form-data">
        <h3>property details</h3>

        <div class="box">
            <p>property name <span>*</span></p>
            <input type="text" name="property_name" class="input" maxlength="50"  required
            placeholder="enter property name">
        </div>
        
        <div class="flex">

            <div class="box">
                <p>property price <span>*</span></p>
                <input type="number" name="price" class="input" max="9999999999" min="0" maxlength="10" required
                placeholder="enter property price">
            </div>

            <div class="box">
                <p>deposite amount <span>*</span></p>
                <input type="number" name="deposite" class="input" max="9999999999" min="0" maxlength="10" required
                placeholder="enter deposite amount">
            </div>

            <div class="box">
                <p>property address <span>*</span></p>
                <input type="text" name="address" class="input"  maxlength="100" required
                placeholder="enter property address">
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
                <p>property type <span>*</span></p>
                <select name="type" class="input" required>
                    <option value="flat">flat</option>
                    <option value="house">house</option>
                    <option value="shop">shop</option>
                </select>
            </div>

            
            <div class="box">
                <p>property status <span>*</span></p>
                <select name="status" class="input" required>
                    <option value="ready to move">ready to move</option>
                    <option value="under construction">under construction</option>
                </select>
            </div>
            
            <div class="box">
                <p>furnished status <span>*</span></p>
                <select name="furnished" class="input" required>
                    <option value="unfurnished">unfurnished</option>
                    <option value="semi-furnished">semi-furnished</option>
                    <option value="furnished">furnished</option>
                </select>
            </div>
            
            <div class="box">
                <p>how may BHK <span>*</span></p>
                <select name="bhk" class="input" required>
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
                <p>how may bedrooms <span>*</span></p>
                <select name="bedroom" class="input" required>
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
                <p>how may bathrooms <span>*</span></p>
                <select name="bathroom" class="input" required>
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
                <p>how may balconys <span>*</span></p>
                <select name="balcony" class="input" required>
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
                <p>carpet area (sqft) <span>*</span></p>
                <input type="number" name="carpet" class="input" max="9999999999" min="0" maxlength="10" required
                placeholder="how may squarefits">
            </div>
            
            <div class="box">
                <p>property age <span>*</span></p>
                <input type="number" name="age" class="input" max="99" min="0" maxlength="2" required
                placeholder="how old is property">
            </div>
            
            
            <div class="box">
                <p>total floors <span>*</span></p>
                <input type="number" name="total_floors" class="input" max="99" min="0" maxlength="2" required
                placeholder="how many floors available?">
            </div>

            <div class="box">
                <p>room floors <span>*</span></p>
                <input type="number" name="room_floor" class="input" max="99" min="0" maxlength="2" required
                placeholder="property floor number">
            </div>
            
            
            <div class="box">
                <p>loan <span>*</span></p>
                <select name="loan" class="input" required>
                    <option value="available">available</option>
                    <option value="not available">not available</option>
                </select>
            </div>
            
            <div class="box">
                <p>property description <span>*</span></p>
                    <textarea name="description" class="input" cols="30" rows="10" maxlength="1000"
                    required placeholder="enter property description"></textarea>
            </div>
        </div>

        <div class="checkbox">
            <div class="box">
                <label><input type="checkbox" name="lift" value="yes">lifts</label>
                <label><input type="checkbox" name="security_guard" value="yes">security guard</label>
                <label><input type="checkbox" name="play_guard" value="yes">play ground</label>
                <label><input type="checkbox" name="garden" value="yes">garden</label>
                <label><input type="checkbox" name="water_supply" value="yes">water supply</label>
                <label><input type="checkbox" name="power_backup" value="yes">power backup</label>
            </div>

            <div class="box">
                <label><input type="checkbox" name="parking_area" value="yes">parking area</label>
                <label><input type="checkbox" name="gym" value="yes">gym</label>
                <label><input type="checkbox" name="shopping_mall" value="yes">shopping_mall</label>
                <label><input type="checkbox" name="hospital" value="yes">hospital</label>
                <label><input type="checkbox" name="school" value="yes">school</label>
                <label><input type="checkbox" name="market_area" value="yes">market area</label>
            </div>
        </div>

        <div class="box">
            <p>image 01 <span>*</span></p>
            <input type="file" name="image_01" class="input" accept="image/*">
        </div>

        <div class="flex">

            <div class="box">
                <p>image 02</p>
                <input type="file" name="image_02" class="input" accept="image/*">
            </div>

            <div class="box">
                <p>image 03 </p>
                <input type="file" name="image_03" class="input" accept="image/*">
            </div>

            <div class="box">
                <p>image 04 </p>
                <input type="file" name="image_04" class="input" accept="image/*">
            </div>

            <div class="box">
                <p>image 05 </p>
                <input type="file" name="image_05" class="input" accept="image/*">
            </div>

        </div>
            <input type="submit" value="post property" name="post" class="btn">
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
