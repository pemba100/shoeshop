<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="main.css?version=2.0">
</head>
<body>
  <section class= " popular-brands">

      <h2>POPULAR BRANDS</h2>
      <div class="controls">
      <i class="fa-solid fa-arrow-left"></i>
      <i class="fa-solid fa-arrow-right"></i>

      </div>

      <div class="popular-brands-content">
        <?php
     $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
     if (mysqli_num_rows($select_products)>0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)){


        ?>
        <form method="post" class="card">
     <img src="image/<?php echo $fetch_products['image']; ?>">
      <div class="price">$<?php echo $fetch_products['price']; ?></div>
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>" >
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>" >
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>" >
    <input type="hidden" name="product_quantity" value="1" min="1">
    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>" >
    <div class="icon">
        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class=" fa-regular fa-eye" ></a>
        <button type="submit" name="add_to_wishlist" class="fa-regular fa-heart" ></button>
        <button type="submit" name="add_to_cart" class="fa-solid fa-cart-shopping" ></button>

    </div>
    </form>
        <?php
      }
  }else{
  echo '<p class="empty">no products added yet!</p>';
}
        ?>
      </div>
    </section>   

<script>

    document.addEventListener("DOMContentLoaded", () => {
        const leftArrow = document.querySelector(".fa-arrow-left");
        const rightArrow = document.querySelector(".fa-arrow-right");
        const brandsContent = document.querySelector(".popular-brands-content");

    if (leftArrow && rightArrow && brandsContent) {
        // Scroll left
        leftArrow.addEventListener("click", () => {
            brandsContent.scrollBy({
                left: -400, // Scroll distance to the left
                behavior: "smooth",
            });
        });

        // Scroll right
        rightArrow.addEventListener("click", () => {
            brandsContent.scrollBy({
                left: 400, // Scroll distance to the right
                behavior: "smooth",
            });
        });
    } else {
        console.error("Elements not found: Make sure your selectors are correct.");
    }
});

</script>
</body>
</html>