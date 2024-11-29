<?php

  $conn = mysqli_connect('localhost','root','','shoe_db') or die('connection failed');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully\n";
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function insertAdminUser($conn) {
    $name = 'Admin';
    $email = 'admin@shoeshop.com';
    $password = hashPassword('Admin@123'); 
    $user_type = 'admin'; 
    
    $query = "INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssss", $name, $email, $password, $user_type);
        
        if ($stmt->execute()) {
            echo "Admin user inserted successfully.\n";
        } else {
            echo "Failed to insert admin user: " . $stmt->error . "\n";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error . "\n";
    }
}

insertAdminUser($conn);

$conn->close();
?>
