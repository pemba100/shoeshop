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
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('Query failed');
    $message[] = 'User removed successfully';
    header('location:admin_user.php');
    exit();
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

    <section class="message-container" style="text-align: center; padding: 20px;">
    <h1 class="title" style="font-size: 24px; margin-bottom: 20px;">Total User Accounts</h1>
    <div class="table-container" style="padding: 20px;">
        <table style="width: 100%; border-collapse: collapse; margin: auto; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background-color: #f4f4f4; text-align: left; border-bottom: 2px solid #ddd;">
                    <th style="padding: 12px; border: 1px solid #ddd;">User ID</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Name</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">User Type</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die("Query failed");
                if (mysqli_num_rows($select_users) > 0) {
                    while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                        ?>
                        <tr style="border-bottom: 1px solid #ddd; text-align: center;">
                            <td style="padding: 12px; border: 1px solid #ddd;"><?php echo $fetch_users['id']; ?></td>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?php echo $fetch_users['name']; ?></td>
                            <td style="padding: 12px; border: 1px solid #ddd;"><?php echo $fetch_users['email']; ?></td>
                            <td style="padding: 12px; border: 1px solid #ddd; color: <?php echo ($fetch_users['user_type'] == 'admin') ? 'orange' : 'black'; ?>;">
                                <?php echo $fetch_users['user_type']; ?>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <a href="admin_user.php?delete=<?php echo $fetch_users['id']; ?>" 
                                   onclick="return confirm('Delete this user?');" 
                                   style="padding: 8px 15px; background-color: red; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; transition: 0.3s;">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: #555; font-size: 18px;">No users found!</td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>


    <div style="width: 90%; max-width: 600px; height: 2px; background-color: #ddd; margin: 20px auto;"></div>

</body>
</html>
