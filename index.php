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
     <link rel="stylesheet" href="main.css?version=2.0">

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

<?php include 'footer.php'; ?>






<script>

</script>

</body>
</html>