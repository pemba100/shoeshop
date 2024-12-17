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
    <link rel="stylesheet" href="main.css">
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'footer.php'; ?>

<!-- <script type="text/javascript" src="script2.js"></script> -->
</body>
</html>