<?php
include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
}

// Add product to database
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'image/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$product_name'") or die('query failed');
    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `products`(`name`, `price`, `product_detail`, `image`) VALUES ('$product_name','$product_price','$product_detail','$image')") or die('query failed');
        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully';
            }
        }
    }
}

// Deleting product from database
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id= '$delete_id'") or die('query failed');

    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('image/' . $fetch_delete_image['image']);

    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

    header('location:admin_product.php');
}

// Handling edit functionality
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die('query failed');
    $product = mysqli_fetch_assoc($select_product);
}

// Update product
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_detail = $_POST['update_detail'];
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'image/' . $update_image;

    $update_query = mysqli_query($conn, "UPDATE `products` SET `name`='$update_name', `price`='$update_price', `product_detail`='$update_detail', `image`='$update_image' WHERE id = '$update_id'") or die('query failed');
    if ($update_query) {
        move_uploaded_file($update_image_tmp_name, $update_image_folder);
        header('location:admin_product.php');
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

    <link rel="stylesheet" href="css/style.css?v=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px 15px;
            text-align: center;
        }

        table td {
            padding: 12px 15px;
            text-align: center;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .form-table td {
            padding: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .message {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px 20px;
            color: white;
            background-color: #4CAF50;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message i {
            cursor: pointer;
        }

        .actions a {
            padding: 8px 12px;
            margin: 0 5px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .actions .edit {
            background-color: #2196F3;
        }

        .actions .edit:hover {
            background-color: #0b7dda;
        }

        .actions .delete {
            background-color: #f44336;
        }

        .actions .delete:hover {
            background-color: #da190b;
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
            <span>' . $msg . '</span>
            <i class="fa-solid fa-circle-xmark" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>

    <table>
        <tr>
            <th colspan="2">Add New Product</th>
        </tr>
        <tr>
            <td colspan="2">
                <form method="POST" enctype="multipart/form-data">
                    <table class="form-table">
                        <tr>
                            <td><label for="name">Product Name</label></td>
                            <td><input type="text" name="name" id="name" required></td>
                        </tr>
                        <tr>
                            <td><label for="price">Product Price</label></td>
                            <td><input type="number" name="price" id="price" required></td>
                        </tr>
                        <tr>
                            <td><label for="detail">Product Detail</label></td>
                            <td><textarea name="detail" id="detail" required></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="image">Product Image</label></td>
                            <td><input type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png, image/webp" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="add_product" value="Add Product" class="btn">
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Actions</th>
        </tr>
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
        <tr>
            <td><img src="image/<?php echo $fetch_products['image']; ?>" alt="" style="width: 80px; border-radius: 5px;"></td>
            <td><?php echo $fetch_products['name']; ?></td>
            <td>Rs. <?php echo number_format($fetch_products['price'], 2); ?></td>
            <td class="actions">
                <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">Edit</a>
                <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="4">No products added yet.</td></tr>';
        }
        ?>
    </table>

    <?php if (isset($_GET['edit'])) { ?>
    <table>
        <tr>
            <th colspan="2">Update Product</th>
        </tr>
        <tr>
            <td colspan="2">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="update_id" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">
                    <table class="form-table">
                        <tr>
                            <td><label for="update_name">Product Name</label></td>
                            <td><input type="text" name="update_name" id="update_name" value="<?php echo isset($product['name']) ? $product['name'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="update_price">Product Price</label></td>
                            <td><input type="number" name="update_price" id="update_price" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="update_detail">Product Detail</label></td>
                            <td><textarea name="update_detail" id="update_detail" required><?php echo isset($product['product_detail']) ? $product['product_detail'] : ''; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="update_image">Product Image</label></td>
                            <td><input type="file" name="update_image" id="update_image" accept="image/jpg, image/jpeg, image/png, image/webp"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="update_product" value="Update Product" class="btn">
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
    <?php } ?>

</body>
</html>
