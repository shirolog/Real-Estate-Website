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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<!-- header section -->
<?php require('./assets/components/user_header.php') ?>

<!-- about section -->
<section class="about">

    <div class="row">
        <div class="image">
            <img src="./assets/images/about-img.svg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Dolore neque quod, est beatae voluptas labore facere id exercitationem
             non, eveniet ducimus laudantium numquam</p>
             <a href="./contact.php" class="inline-btn">contact us</a>
        </div>
    </div>

</section>

<!-- steps section -->
<section class="steps">

    <h1 class="heading">3 simple steps</h1>

    <div class="box-container">
        
        <div class="box">
            <img src="./assets/images/step-1.png" alt="">
            <h3>search property</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Sint, asperiores.</p>
        </div>

        <div class="box">
            <img src="./assets/images/step-2.png" alt="">
            <h3>contact dealer</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Sint, asperiores.</p>
        </div>

        <div class="box">
            <img src="./assets/images/step-3.png" alt="">
            <h3>enjoy property</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Sint, asperiores.</p>
        </div>

    </div>

</section>

<!-- reviews section -->
<section class="reviews">

    <h1 class="heading">client's reviews</h1>

    <div class="box-container">

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-1.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
        </div>

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-2.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
        </div>

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-3.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
        </div>

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-4.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
        </div>

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-5.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
        </div>

        <div class="box">
            <div class="user">
                <img src="./assets/images/pic-6.png" alt="">
                <div>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Natus hic iure pariatur facere adipisci consequatur quod
                 velit, possimus quae officiis.
            </p>
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