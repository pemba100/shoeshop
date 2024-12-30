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
    <link rel="stylesheet" href="main.css?version=1.0">
     <!-- <link rel="stylesheet" href="main.css"> -->


</head>

<body>
<?php include 'header.php'; ?>

<div class="banner3">
    <div class="detail">
        <h1>OUR SHOP</h1>
    </div>
    <!-- <a href="index.php">Home</a> <span>/ About Us</span> -->
</div>

<section class= "shop ">

<h2 class="title">Shop best sellers</h2>

<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '<span class="close-btn">&times;</span></div>';
    }
}
?>


<div class="box-container">
  <?php
$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
if (mysqli_num_rows($select_products)>0) {
  while ($fetch_products = mysqli_fetch_assoc($select_products)){


  ?>
  <form method="post" class="box">
<img src="image/<?php echo $fetch_products['image']; ?>">
<div class="price">$<?php echo $fetch_products['price']; ?></div>
<div class="name"><?php echo $fetch_products['name']; ?></div>
<input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>" >
<input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>" >
<input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>" >
<input type="hidden" name="product_quantity" value="1" min="1">
<input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>" >
<div class="icon">
  <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class=" fa-regular fa-eye" ></a>
  <button type="submit" name="add_to_wishlist" class="fa-regular fa-heart" ></button>
  <button type="submit" name="add_to_cart" class="fa-solid fa-cart-shopping" ></button>

</div>
</form>
  <?php
}
}else{
echo '<p class="empty">no products added yet!</p>';
}
  ?>
</div>
</section> 


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