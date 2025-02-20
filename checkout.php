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
if(isset($_POST['order_btn'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $shoe_size = mysqli_real_escape_string($conn, $_POST['shoe_size']);
    $placed_on = date('d-M-Y');
     $cart_total=0;
     $cart_product[]='';
     $cart_query=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

     if (mysqli_num_rows($cart_query)>0) {
        while($cart_item=mysqli_fetch_assoc($cart_query)) {
            $cart_product[]=$cart_item['name'].' ('.$cart_item['quantity'].')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total+=$sub_total;
        }
     }
     $total_products = implode(',', $cart_product);
     mysqli_query($conn, "INSERT INTO `orders` (`user_id`, `name`, `number`, `email`, `method`, `address`, `shoe_size`, `total_products`, `total_price`, `placed_on`) 
     VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$shoe_size', '$total_products', '$cart_total', '$placed_on')");
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
    $message[]='order placed successfully';
    header('location:checkout.php');  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="css/checkout.css?v=1.0">
</head>
<body>
<?php include 'header.php'; ?>

   
     <h1>payment</h1>
     
<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '<span class="close-btn">&times;</span></div>';
    }
}
?>  

   
<div class="display-order">
   <div class="checkout-container">
     <?php     
      $select_cart=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'" ) or die ('query failed');
       $total=0;
       $grand_total=0;
       if(mysqli_num_rows($select_cart)>0) {
           while($fetch_cart=mysqli_fetch_assoc($select_cart)) {
            $total_price=($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total=$total+=$total_price;
    
     ?>  
          <div class="box">
            <img src="image/<?php echo $fetch_cart['image'];?>" alt="">
            <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity'];?>)</span>
          </div>
          <?php
            }
        }
        ?>
    </div>
     <span class="grand-total"> Total Amount Payable : $ <?= $grand_total; ?></span>
   </div>
     <form method="post">
        <div class="input-field">
            <label >your name</label>
            <input type="text" name="name" placeholder="enter your name " required>
        </div>
        <div class="input-field">
            <label >your number</label>
            <input type="number" name="number" placeholder="enter your number " required>
        </div>
        <div class="input-field">
            <label >your email</label>
            <input type="text" name="email" placeholder="enter your email" required>
        </div>
        <div class="input-field">
            <label >select payment method </label>
              <select name="method" id="">
                <option selected disabled> select payment method</option>
                  <option value="cash on delivery"> cash on delivery</option>

              </select >
        </div>
        <div class="input-field">
            <label>address</label>
            <input type="text" name="address" placeholder="enter your address " required>
        </div>
        <label>Select Shoe Size</label>
    <select name="shoe_size" required>
        <option selected disabled>Select your shoe size</option>
        <option value="31">31</option>
        <option value="32">32</option>
        <option value="33">33</option>
        <option value="34">34</option>
        <option value="35">35</option>
        <option value="36">36</option>
        <option value="37">37</option>
        <option value="38">38</option>
        <option value="39">39</option>
        <option value="40">40</option>
        <option value="41">41</option>
        <option value="42">42</option>
        <option value="43">43</option>
        <option value="44">44</option>
        <option value="45">45</option>
        <option value="46">46</option>
        <option value="47">47</option>        

    </select>
</div>
        <input type="submit" name="order_btn" class="btn" value="order now ">
     </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>