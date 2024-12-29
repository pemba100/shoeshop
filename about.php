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
    <link rel="stylesheet" href="main.css?version=1.0">.
     <!-- <link rel="stylesheet" href="main.css"> -->


</head>

<body>
<?php include 'header.php'; ?>

<div class="banner2">
    <div class="detail2">
        <h1>About Us</h1>
    </div>
    <!-- <a href="index.php">Home</a> <span>/ About Us</span> -->
</div>

<div class="about-us">
    <div class="about-row">
        <div class="about-box">
            <div class="about-title">
                <h1>About Our Jutta Pasal</h1>
                <h2>Four Months of Experience</h2>
            </div>
            <p>
                Our Jutta Pasal, with four months of experience, has quickly established itself as a reliable destination for quality footwear. Based in Nepal, we cater to diverse customer needs by offering a wide selection of stylish, comfortable, and affordable shoes for all occasions. Our user-friendly website ensures a seamless shopping experience, backed by efficient customer service and timely delivery. This early journey has been enriched by positive feedback, helping us grow and refine our offerings to meet the expectations of our valued customers.
            </p>
        </div>
        <div class="about-img-box">
            <img src="img/about.jpg" alt="About Us Image">
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>

</body>

</html>