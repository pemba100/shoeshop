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


// updateing qty
if (isset($_POST['update_qty_btn'])) {
    $update_qty_id = $_POST['update_qty_id'];
    $update_value = $_POST['update_qty'];
    
    $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity ='$update_value' WHERE id = '$update_qty_id'") or die('Query failed');
    
    if ($update_query) {
        header('Location: cart.php'); 
        exit();
    }
}


//delete product from your wishlist

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');

    header('location:cart.php');
}

//delete product from your wishlist

if (isset($_GET['delete_all'])) {

    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

    header('location:cart.php');
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
        <h1>MY CART</h1>
    </div>
    <!-- <a href="index.php">Home</a> <span>/ wishlist</span> -->
</div>

<section class= "shop">
    <h1 class="title"> products added in cart</h1>

<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '<span class="close-btn">&times;</span></div>';
    }
}
?>  
<div class="box-container">
  <?php

  $grand_total=0;
$select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
if (mysqli_num_rows($select_cart)>0) {
  while ($fetch_cart = mysqli_fetch_assoc($select_cart)){
  ?>
  <div class="box">
      <img src="image/<?php echo $fetch_cart['image']; ?>">
      <div class="price">$<?php echo $fetch_cart['price']; ?></div>
      <div class="name"><?php echo $fetch_cart['name']; ?></div>
      
      <form action="cart.php" method="POST">
          <input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id']; ?>">
          <div class="qty">
              <input type="number" min="1" name="update_qty" value="<?php echo $fetch_cart['quantity']; ?>">
              <input type="submit" name="update_qty_btn" value="update">
            </div>
            <div class="icon">
            <!-- <a href="view_page.php?pid=<?php echo $fetch_cart['id']; ?>" class=" fa-regular fa-eye" ></a> -->
            <a href="cart.php?delete=<?php echo $fetch_cart['pid'];?>"class="fa-regular fa-circle-xmark" onclick="return confirm('do you want to delete this product from your cart')" ></a>
            <button type="submit" name="add_to_cart" class="fa-solid fa-cart-shopping" ></button>
          
          </div>
</form>
<div class="total-amt">
    Total Amount : <span><?php echo $total_amt = ($fetch_cart['price']*$fetch_cart['quantity']) ?></span>
</div>
</div>

  <?php
  $grand_total+=$total_amt;
}
}else{
echo '<p class="empty">no products added yet!</p>';
}
  ?>
  </div>
  <div class="dlt">
  <a href="cart.php?delete_all" class="btn2  <?php echo ($grand_total>1)?'':'disabled'?>" onclick="return confirm('do you want to delete all items in your cart')">delete all</a>
  </div>
  <div class="wishlist_total">
  <p>total amount payable : <span>$<?php echo  $grand_total; ?>/-</span></p>
  <a href="shop.php" class="continuebtn">continue shopping</a>
  <a href="checkout.php" class="btn3"> proceed to checkout</a>
  </div>
</section> 
<?php include 'footer.php'; ?>


</script>
</body>

</html>