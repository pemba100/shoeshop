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




//adding product in wishlist
if(isset($_POST['add_to_wishlist'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($wishlist_number)>0) {
        $message[]='product already exist in wishlist';
    } else if (mysqli_num_rows($cart_num)>0){
        $message[]='product already exist in cart';

    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
        $message[]='product successfully added  in your wishlist';

    }
}

//adding product in cart
if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity= $_POST['product_quantity'];

    
    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($cart_num)>0){
        $message[]='product already exist in cart';

    } else {
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
        $message[]='product successfully added  in your cart';

    }
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
        <div class="row1">
            <div class="box1">
                <span>Our story</span>
                <h1>Crafting Excellence in Footwear Since 2024</h1>
                <p>Welcome to Jutta Pasal, where quality meets craftsmanship. Since our inception in 2024, we have been dedicated to providing our customers with premium footwear that combines style, comfort, and durability. Every step of our journey is rooted in passion, innovation, and a commitment to excellence.</p>
            <p>From sourcing the finest materials to ensuring every pair fits perfectly, we take pride in delivering shoes that cater to your unique needs. Whether you’re stepping out for work, play, or adventure, our collection has something for everyone. Thank you for making us a part of your journey—one step at a time.</p>
            <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="box-img">
                <img src="img/addidasshoe.jpg" alt="">

            </div>
        </div>
       </div>



       <?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '<span class="close-btn">&times;</span></div>';
    }
}
?>


       <?php include 'homeshop.php'; ?>
       <?php include 'footer.php'; ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    const closeButtons = document.querySelectorAll('.close-btn');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const messageBox = button.parentElement;
            messageBox.style.display = 'none';
        });
    });
  });

</script>
</body>

</html>