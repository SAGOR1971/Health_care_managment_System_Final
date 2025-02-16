<?php 
include 'connect.php';

// Update logic
if (isset($_POST['update_product'])) {
    $update_product_id = $_POST['update_product_id'];
    $update_product_name = $_POST['update_product_name'];
    $update_product_price = $_POST['update_product_price'];
    $update_product_image = $_FILES['update_product_image']['name'];
    $update_product_image_tmp_name = $_FILES['update_product_image']['tmp_name'];
    $update_product_image_folder = 'images/' . $update_product_image;

    // Update query
    $update_product = mysqli_query($conn, "UPDATE `products` SET 
        name='$update_product_name', price='$update_product_price', 
        image='$update_product_image' WHERE id=$update_product_id");

    if ($update_product) {
        move_uploaded_file($update_product_image_tmp_name, $update_product_image_folder);
        header('location:view_products.php');
    } else {
        $display_message = "There is some error inserting product";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .display_message {
            background-color: #ffcccb;
            color: #d8000c;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .display_message i {
            cursor: pointer;
        }

        .edit_container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .update_product {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
        }

        .product_container_box img {
            width: 200px;
            height: auto;
            margin-top: 20px;
            margin-left: 100px;
        }

        .input_fields {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btns {
            display: flex;
            justify-content: space-between;
        }

        .edit_btn, .cancel_btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit_btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit_btn:hover {
            background-color: #45a049;
        }

        .cancel_btn {
            background-color: #f44336;
            color: white;
        }

        .cancel_btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>
    
    <?php
    if (isset($display_message)) {
        echo "<div class='display_message'>
            <span>$display_message</span>
            <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
        </div>";
    }
    ?>

    <section class="edit_container">
        <!-- PHP code to fetch product details -->
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id=$edit_id");
            
            if (mysqli_num_rows($edit_query) > 0) {
                $fetch_data = mysqli_fetch_assoc($edit_query);
        ?>
        
        <!-- Form to update product -->
        <form action="" method="post" enctype="multipart/form-data" class="update_product product_container_box">
            <img src="images/<?php echo $fetch_data['image']; ?>" alt="">
            <input type="hidden" value="<?php echo $fetch_data['id']; ?>" name="update_product_id">
            <input type="text" class="input_fields fields" required value="<?php echo $fetch_data['name']; ?>" name="update_product_name">
            <input type="number" class="input_fields fields" required value="<?php echo $fetch_data['price']; ?>" name="update_product_price">
            <input type="file" class="input_fields fields" accept="image/png, image/jpg, image/jpeg" name="update_product_image">
            
            <div class="btns">
                <input type="submit" class="edit_btn" value="Update product" name="update_product">
                <input type="reset" id="close-edit" value="Cancel" class="cancel_btn">
            </div>
        </form>

        <?php
            }
        }
        ?>
    </section>

</body>
</html>
