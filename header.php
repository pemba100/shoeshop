<?php
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Not logged in';

// Check if the user is logged in and set user_id

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize row counts for wishlist and cart
$wishlist_num_rows = 0;
$cart_num_rows = 0;

// Fetch wishlist count
if ($user_id) {
    $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die('Query failed');
    $wishlist_num_rows = mysqli_num_rows($select_wishlist);
}

// Fetch cart count
if ($user_id) {
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Query failed');
    $cart_num_rows = mysqli_num_rows($select_cart);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
     <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="main.css">

 </head>
<body>
    <header class="header">
        <div class="flex">
            <a href="" class="logo"> <img src="img/logo.jpeg" alt=""> </a>
            <nav class="navbar">
                <a href="index.php">home</a>
                <a href="shop.php"> shop</a>
                <a href="order.php"> order</a>
                <a href="about.php">About us</a>
                <a href="contact.php">Contact us</a>

            </nav>
            <div class="icons">
                <i class="fa-solid fa-user" id="user-btn"></i>
        
                <a href="wishlist.php"><i class="fa-regular fa-heart"></i><sup><?php echo $wishlist_num_rows; ?></sup></a>
          
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php echo $cart_num_rows; ?></sup></a>
                <i class="fa-solid fa-list" id="menu-btn"></i>
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
