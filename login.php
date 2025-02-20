<?php
include 'connection.php';
session_start();

if (isset($_POST['submit-btn'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die(mysqli_error($conn));

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('Location: admin_pannel.php');
                exit();
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: index2.php');
                exit();
            }
        } else {
            $message[] = 'Incorrect email or password.';
        }
    } else {
        $message[] = 'No account found with this email.';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <title>register page</title>
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if (isset($_GET['message'])) {
    echo '
    <div class="message">
        <span>' . htmlspecialchars($_GET['message']) . '</span>
        <i class="fa-regular fa-circle-xmark" onclick="this.parentElement.remove()"></i>
    </div>
    ';
}
?>


    <section class="form-container">
        <form action="" method="post">
            <h1>login now </h1>
     <div class="input-fields">
        <label>your email :</label><br>
        <input type="email" name="email" placeholder=" enter your email" required>
     </div>   
     
     <div class="input-fields">
        <label>your password :</label> <br>
        <input type="password" name="password" placeholder=" enter your password" required>
     </div> 

            <input type="submit" name="submit-btn" value="login now" class="btn ">
            <p>do not have an account? <a href="register.php">register now </a></p>
        </form>
  </section>
  
</body>
</html>

