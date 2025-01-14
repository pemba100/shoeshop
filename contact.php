<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
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
    <link rel="stylesheet" href="main.css?version=1.0">
     <!-- <link rel="stylesheet" href="main.css"> -->
</head>
<body>
<?php include 'header.php'; ?>
<div class="contact">
        <h1>Contact</h1>

    <!-- <a href="index.php">Home</a> <span>/ wishlist</span> -->
</div>

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

 <div class="contact-address">
    <h1 class="contact-title">OUR CONTACT</h1>
     <div class="contact-row">
      
     <div class="contact-box">
         <i class="fa-solid fa-location-dot"></i>
          <div class="inside-contactbox">
           <h1>address</h1>
           <p>kathmandu,nepal</p>
          </div>

       </div>

       <div class="contact-2box">
          <i class="fa-solid fa-location-dot"></i>
          <div class="inside-2contactbox">
              <h1>Number</h1>
                    <p>9800000000</p>
          </div>

       </div>
     </div>

 </div>
<?php include 'footer.php'; ?>
</body>
</html>