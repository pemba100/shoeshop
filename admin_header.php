<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin pannel</title>
    <script
      src="https://kit.fontawesome.com/9152afbf8d.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <header class="header">
    <div class="flex">
        <a href="admin_pannel.php" class="logo"> <img src="img/logo.jpg" alt=""> </a>
        <nav class="navbar">
            <a href="admin_pannel.php">home</a>
            <a href="admin_product.php"> products</a>
            <a href="admin_order.php"> orders</a>
            <a href="admin_user.php">users</a>
            <a href="admin_message.php">messages</a>


        </nav>
        <div class="icons">
        <i class="fa-solid fa-user" id="user-btn"></i>
        <i class="fa-solid fa-list" id="menu-btn"></i>


        </div>
        <div class="user-box">
        <p>username : <span> <?php  echo $_SESSION['admin_name']; ?></span></p>
        <p>Email : <span> <?php echo $_SESSION['admin_email']; ?></span></p>
   <form method="post">
    <button type="submit" class="logout-btn">logout </button>

   </form>
       

        </div>

    </div>

</header>
 <div class="banner">
    <div class="detail">
        <h1>admin dashboard</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, exercitationem!</p>

    </div>
 </div>
   <div class="line">

   </div>
</body>
</html> -->



<?php

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Guest';
$admin_email = isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : 'Not logged in';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
    <script
      src="https://kit.fontawesome.com/9152afbf8d.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/style.css">

 </head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin_pannel.php" class="logo"> <img src="image/logo.jpg" alt=""> </a>
            <nav class="navbar">
                <a href="admin_pannel.php">home</a>
                <a href="admin_product.php"> products</a>
                <a href="admin_order.php"> orders</a>
                <a href="admin_user.php">users</a>
            </nav>
            <div class="icons">
                <i class="fa-solid fa-user" id="user-btn"></i>
                <i class="fa-solid fa-list" id="menu-btn"></i>
            </div>
            <div class="user-box">
                <p>Username: <span> <?php echo $admin_name; ?></span></p>
                <p>Email: <span> <?php echo $admin_email; ?></span></p>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="banner">
        <div class="detail">
            <h1>Admin Dashboard</h1>
        </div>
    </div>
    <div class="line"></div>


    <script type="text/javascript" src="script.js"></script> 

</body>
</html>
