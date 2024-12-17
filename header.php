

<?php

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Not logged in';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
     <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">

 </head>
<body>
    <header class="header">
        <div class="flex">
            <a href="" class="logo"> <img src="image/logo.jpeg" alt=""> </a>
            <nav class="navbar">
                <a href=".php">Home</a>
                <a href=".php"> Shop</a>
                <a href=".php"> orders</a>
                <a href=".php">About us</a>
                <a href=".php">Contact us</a>

            </nav>
            <div class="icons">
                <i class="fa-solid fa-user" id="user-btn"></i>
            </div>
            <div class="user-box">
                <p>Username: <span> <?php echo $user_name; ?></span></p>
                <p>Email: <span> <?php echo $user_email; ?></span></p>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>




<script>
let userBtn = document.querySelector('#user-btn');

userBtn.addEventListener('click', function(){
    let userBox = document.querySelector('.user-box');
  userBox.classList.toggle('active');
})

</script>

</body>
</html>
