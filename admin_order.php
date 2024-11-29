<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_name'];
if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

$message = [];

// Delete a user from the database
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('Query failed');
    $message[] = 'User removed successfully';
    header('location:admin_order.php');
    exit();
}


// <!-- payment -->
if (isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    
    mysqli_query($conn, "UPDATE `orders` SET payment_status ='$update_payment' WHERE id ='$order_id' ") or die('query failed');
    
}

     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://kit.fontawesome.com/9152afbf8d.js" crossorigin="anonymous"></script>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; margin: 0; padding: 0;">

    <?php include 'admin_header.php'; ?>

    <?php
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message" style="background-color: #4CAF50; color: white; padding: 10px; margin: 10px auto; border-radius: 5px; width: 90%; max-width: 600px; display: flex; justify-content: space-between; align-items: center;">
                <span>' . $msg . '</span>
                <i class="fa-solid fa-circle-xmark" style="cursor: pointer; font-size: 20px; margin-left: 10px;" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>

    <div style="width: 90%; max-width: 600px; height: 2px; background-color: #ddd; margin: 20px auto;"></div>

    <section class="order-container" style="text-align: center; padding: 20px;">
        <h1 class="title" style="font-size: 24px; margin-bottom: 20px;">Total Orders</h1>
        <div class="box-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 20px; padding: 20px;">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die("Query failed");
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                    ?>
                    <div class="box" style="background-color: #fff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 15px; text-align: center;">
                        <p style="margin: 10px 0; font-size: 16px;">User Name: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['name']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">User ID: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['user_id']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Placed On: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['placed_on']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Number: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['number']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Email: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['email']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Total Price: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['total_price']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Method: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['method']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Address: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['address']; ?></span>
                        </p>
                        <p style="margin: 10px 0; font-size: 16px;">Total Products: 
                            <span style="font-weight: bold;"><?php echo $fetch_orders['total_products']; ?></span>
                        </p>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <select name="update_payment" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; font-size: 14px;">
                                <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                                <option value="pending">Pending</option>
                                <option value="complete">Complete</option>
                            </select> <br>
                            <button type="submit" style="margin-top: 10px;  padding: 8px 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;" name="update_order" value="update payment">Update</button>
                        </form>
                        <a href="admin_order.php?delete=<?php echo $fetch_orders['id']; ?>" 
                           onclick="return confirm('Delete this order?');" 
                           style="display: inline-block; margin-top: 10px; margin-left:20px; padding: 8px 15px; background-color: red; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: 0.3s;">
                           Delete
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo '
                <div class="empty" style="text-align: center; font-size: 18px; margin: 20px 0; color: #555;">
                    <p>No orders placed</p>
                </div>
                ';
            }
            ?>
        </div>
    </section>

    <div style="width: 90%; max-width: 600px; height: 2px; background-color: #ddd; margin: 20px auto;"></div>

</body>
</html>
