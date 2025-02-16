<?php
include 'connect.php';
if(isset($_POST['add_to_cart'])){
    $products_name = $_POST['product_name'];
    $products_price = $_POST['product_price'];
    $products_image = $_POST['product_image'];
    $products_quantity = 1;
    
    $select_cart= mysqli_query($conn,"SELECT * FROM `cart` WHERE name='$products_name'");
    if (mysqli_num_rows($select_cart) > 0) {
        $display_message[] = "Product already added to cart";
    } else {
        $insert_products = mysqli_query($conn,"INSERT INTO `cart` (name, price, image, quantity) VALUES ('$products_name','$products_price','$products_image','$products_quantity')");
        $display_message[] = "Product added to cart";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        margin: 0 auto;
        padding-top: 50px;
    }

    .heading {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    /* Product Container */
    .product_container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Centers products in a row */
        align-items: flex-start;
        gap: 20px;
    }

    /* Product Card */
    .edit_form {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;  /* Fixed width */
        max-width: 250px;
        text-align: center;
        padding: 20px;
        transition: transform 0.3s ease-in-out;
        margin: 0 auto;  /* Ensures center alignment */
    }

    .edit_form:hover {
        transform: translateY(-10px);
    }

    .edit_form img {
        width: 100%;
        height: 180px; /* Fixed height to make all images uniform */
        object-fit: contain; /* Prevents image distortion */
        border-radius: 10px;
    }

    .edit_form h3 {
        font-size: 1.5rem;
        color: #333;
        margin: 15px 0;
    }

    .price {
        font-size: 1.2rem;
        color: #e74c3c;
        margin-bottom: 15px;
    }

    .submit_btn {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .submit_btn:hover {
        background-color: #2980b9;
    }

    .cart_btn {
        width: 100%;
    }

    .empty_text {
        text-align: center;
        font-size: 1.5rem;
        color: #e74c3c;
        width: 100%;
    }
</style>

</head>
<body>
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <div class="container">
        <?php
        if(isset($display_message)){
            foreach($display_message as $message){
                echo " <div class='display_message'>
                <span>$message</span>
                <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
            </div>";}
        } 
        ?>
        
        <section class="products">
            <h1 class="heading">Let's Shop</h1>
            <div class="product_container">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                if(mysqli_num_rows($select_products) > 0){
                    while($fetch_product = mysqli_fetch_assoc($select_products)){
                ?>
                <form action="" method="post">
                    <div class="edit_form">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="Product Image">
                        <h3><?php echo $fetch_product['name']; ?></h3>
                        <div class="price">Price: <?php echo $fetch_product['price']; ?> Taka </div>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="submit" class="submit_btn cart_btn" value="Add to Cart" name="add_to_cart">
                    </div>
                </form>
                <?php
                    }
                } else {
                    echo "<div class='empty_text'>No Products Available</div>"; 
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>
