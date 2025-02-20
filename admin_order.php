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
if (isset($_POST['update_order'])) {
    // Check if 'order_id' and 'update_payment' keys exist in the POST request
    if (isset($_POST['order_id']) && isset($_POST['update_payment'])) {
        $order_id = $_POST['order_id'];
        $update_payment = $_POST['update_payment'];

        // Update query
        $query = "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Payment status updated successfully!";
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
    } else {
        echo "Required data is missing.";
    }
}

     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">

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
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #fff;">
        <thead>
            <tr style="background-color: #f5f5f5; text-align: left;">
                <th style="padding: 10px; border: 1px solid #ddd;">User Name</th>
                <th style="padding: 10px; border: 1px solid #ddd;">User ID</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Placed On</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Number</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Total Price</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Method</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Address</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Total Products</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Shoe Size</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Payment Status</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die("Query failed");
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                    ?>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['name']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['user_id']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['placed_on']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['number']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['email']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['total_price']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['method']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['address']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['total_products']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $fetch_orders['shoe_size']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                <select name="update_payment" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; font-size: 14px;">
                                    <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                                    <option value="pending">Pending</option>
                                    <option value="complete">Complete</option>
                                </select> 
                                <br>
                                <button type="submit" style="margin-top: 10px; padding: 8px 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;" name="update_order" value="update payment">Update</button>
                            </form>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <a href="admin_order.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" style="display: inline-block; padding: 8px 15px; background-color: red; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: 0.3s;">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '
                <tr>
                    <td colspan="11" style="padding: 10px; text-align: center; font-size: 18px; color: #555;">
                        No orders placed
                    </td>
                </tr>
                ';
            }
            ?>
        </tbody>
    </table>
</section>
    <div style="width: 90%; max-width: 600px; height: 2px; background-color: #ddd; margin: 20px auto;"></div>

</body>
</html>
