
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shoe Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav {
            background-color: #333;
            padding: 10px 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding-bottom: 20px;
            padding-top: 20px;
            display: flex;
            justify-content: center;
        }
        
        nav ul li {
            margin: 0 15px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            margin-left: 50px;
            font-size: 18px;
        }

        header {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 40px 0;
        }

        section {
            background: url('./img/indexback.jpg') no-repeat center/cover;
            min-height: 423px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
         h2{
            display: block;
         }

        footer {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    
    <header>
        <h1>Welcome to Our Online Shoe Shop</h1>
        <p>Your one-stop destination for the best footwear.</p>
    </header>
    
    <section>
        <h2>Discover Amazing Shoes</h2>
    </section>
    
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Online Shoe Shop. All rights reserved.</p>
    </footer>
</body>
</html>
