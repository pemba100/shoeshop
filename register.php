<?php
include 'connection.php';
if (isset($_POST['submit-btn'])) {
    // Sanitize and escape input
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
    $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

    // Check if the user already exists
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die(mysqli_error($conn));
    
    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Passwords do not match';
        } else {
            // Use single quotes for string values in SQL queries
            $query = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$hashedPassword')";
            if (mysqli_query($conn, $query)) {
                header('Location: login.php?message=User+Created+Successfully');
                exit(); // Ensure the script stops after redirect
            } else {
                $message[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <title>register page</title>
    <script
      src="https://kit.fontawesome.com/9152afbf8d.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $message){
        echo '
        <div class="message">
    <span> '.$message.'</span>
    <i class="fa-regular fa-circle-xmark"  onclick="this.parentElement.remove() "></i>
</div>
        
        ';
    }
}
        ?>
    <section class="form-container">
        <form action="" method="post">
            <h1>Register now </h1>
            <input type="text" name=" name" placeholder=" enter your name" required>
            <input type="email" name=" email" placeholder=" enter your email" required>
            <input type="password" name=" password" placeholder=" enter your password" required>
            <input type="password" name=" cpassword" placeholder=" confirm your password" required>
            <input type="submit" name=" submit-btn" value="register now" class="btn ">
            <p>already have an account? <a href="login.php">login now </a></p>
        </form>
  </section>
  
</body>
</html>

