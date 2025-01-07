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


//adding product in cart
// if(isset($_POST['add_to_cart'])){
//     $product_id = $_POST['product_id'];
//     $product_name = $_POST['product_name'];
//     $product_price = $_POST['product_price'];
//     $product_image = $_POST['product_image'];
//     $product_quantity= $_POST['product_quantity'];

    
//     $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//     if (mysqli_num_rows($cart_num)>0){
//         $message[]='product already exist in cart';

//     } else {
//         mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
//         $message[]='product successfully added  in your cart';

//     }
// }

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($cart_num) > 0) {
        // If the product is already in the cart, update the quantity
        mysqli_query($conn, "UPDATE `cart` SET quantity = quantity + $product_quantity WHERE name = '$product_name' AND user_id = '$user_id'");
        $message[] = 'Product quantity updated in your cart';
    } else {
        // Add the product to the cart if it doesn't exist
        mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
        $message[] = 'Product successfully added to your cart';
    }
}
//delete product from your wishlist

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

    header('location:wishlist.php');
}

//delete product from your wishlist

if (isset($_GET['delete_all'])) {

    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');

    header('location:wishlist.php');
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
        <h1>MY WISHLIST</h1>
    </div>
    <!-- <a href="index.php">Home</a> <span>/ wishlist</span> -->
</div>

<section class= "shop">
    <h1 class="title"> products added in wishlist</h1>

<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '<span class="close-btn">&times;</span></div>';
    }
}
?>
<!-- 
  <?php
   if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $select_products = mysqli_query($conn,"SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');

     if(mysqli_num_rows($select_products)>0) {
        while($fetch_products = mysqli_fetch_assoc($select_products)){

  ?>
   <form method="post" >
 <img src="image/<?php echo $fetch_products['image']; ?>">
    <div class="detail">
    <div class="price">$<?php echo $fetch_products['price']; ?></div>
 <div class="name"><?php echo $fetch_products['name']; ?></div>
 <div class="detail"><?php echo $fetch_products['product_detail']; ?></div> 
 <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>" >
 <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>" >
 <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>" >
 <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>" >
 <div class="icon">
   <button type="submit" name="add_to_wishlist" class="fa-regular fa-heart" ></button>
   <input type="number" name="product_quantity" value="1" min="0" class="quantity">
   <button type="submit" name="add_to_cart" class="fa-solid fa-cart-shopping" ></button> 

 </div>

    </div>
 </form>
   <?php
        }
    }

  }

  ?> -->

  
<div class="box-container">
  <?php

  $grand_total=0;
$select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist`") or die('query failed');
if (mysqli_num_rows($select_wishlist)>0) {
  while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){


  ?>
  <form method="post" class="box">
<img src="image/<?php echo $fetch_wishlist['image']; ?>">
<div class="price">$<?php echo $fetch_wishlist['price']; ?></div>
<div class="name"><?php echo $fetch_wishlist['name']; ?></div>
<input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id']; ?>" >
<input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>" >
<input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>" >
<input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>" >
<div class="icon">
  <!-- <a href="view_page.php?pid=<?php echo $fetch_wishlist['id']; ?>" class=" fa-regular fa-eye" ></a> -->
  <a href="wishlist.php?delete=<?php echo $fetch_wishlist['pid'];?>"class="fa-regular fa-circle-xmark" onclick="return confirm('do you want to delete this product from your wishlist')" ></a>
  <button type="submit" name="add_to_cart" class="fa-solid fa-cart-shopping" ></button>

</div>
</form>
  <?php
  $grand_total+=$fetch_wishlist['price'];
}
}else{
echo '<p class="empty">no products added yet!</p>';
}
  ?>
  </div>
  <div class="wishlist_total">
  <p>total amount payable : <span>$<?php echo  $grand_total; ?>/-</span></p>
  <a href="shop.php" class="continuebtn">continue shopping</a>
  <a href="wishlist.php?delete_all" class="btn2 <?php echo ($grand_total)?'':'disabled'?>" onclick="return confirm('do you want to delete all items in your wishlist')">delete all</a>
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