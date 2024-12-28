<?php

include 'connection.php';
session_start();
$admin_id = $_SESSION['user_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
}

 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <!-- <link rel="stylesheet" href="main.css?version=1.0">. -->
     <!-- <link rel="stylesheet" href="main.css"> -->
     <link rel="stylesheet" href="main.css?version=1.0">

</head>

<body>
<?php include 'header.php'; ?>
   
   <div class="container-fluid">
    <div class="hero-slider">
        <div class="slider-item">
            <img src="img/shoe1.jpg" alt="">
            <div class="slider-caption">
                <span>Step Into Comfort</span>
                <h1>Stylish & Durable <br> Footwear</h1>
                <p>Explore our collection of  shoes for  occasion. Experience unmatched style and comfort with every step.</p>
                <a href="shop.php" class = " btn">shop now</a>
            </div>
        </div>
    </div>
   </div>

      <div class="line"></div>
      <div class="services">
        <div class="row">
            <div class="box">
                <img src="img/freeshopping.jpg" alt="">
                <div>
                    <h1>Free shipping fast </h1>
          <p>Step into convenience with our free shipping on all orders! At jutta pasal, we believe that finding the perfect pair of shoes should be hassle-free, including delivery. </p>
                </div>
         </div>
            <div class="box">
                <img src="img/dollar1.jpg" alt="">
                <div>
                    <h1> Money back & Guarantee </h1>
                 <p>Shop with confidence at jutta pasal your satisfaction is our priority! That’s why we offer a no-hassle money-back guarantee.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/support.jpg" alt="">
                <div>
                    <h1> Online Support 24/7 </h1>
                <p>Welcome to our online support! At  jutta pasal, we’re here to ensure you find the perfect pair of shoes with ease.</p>
                </div>
            </div>
        </div>
      </div>

       <div class="story">
        <div class="row">
            <div class="box">
                <span>Our story</span>
                <h1>Crafting Excellence in Footwear Since 2024</h1>
                <p>Welcome to Jutta Pasal, where quality meets craftsmanship. Since our inception in 2024, we have been dedicated to providing our customers with premium footwear that combines style, comfort, and durability. Every step of our journey is rooted in passion, innovation, and a commitment to excellence.</p>
            <p>From sourcing the finest materials to ensuring every pair fits perfectly, we take pride in delivering shoes that cater to your unique needs. Whether you’re stepping out for work, play, or adventure, our collection has something for everyone. Thank you for making us a part of your journey—one step at a time.</p>
            <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="box">
                <img src="img/addidasshoe.jpg" alt="">

            </div>
        </div>
       </div>

       <?php include 'homeshop.php'; ?>
        <?php include 'footer.php'; ?>

<script>

</script>

</body>
</html>