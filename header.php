<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Store</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        .header {
            background: #2c3e50;
            padding: 15px 20px;
            display: flex;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header_body {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company_Name {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #ecf0f1;
        }

        .navbar {
            display: flex;
            gap: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #ecf0f1;
            font-size: 18px;
            transition: color 0.3s ease-in-out;
        }

        .navbar a:hover {
            color: #f39c12;
        }

        .cart {
            text-decoration: none;
            color: #ecf0f1;
            font-size: 22px;
            position: relative;
        }

        .cart-badge {
            background: red;
            color: white;
            font-size: 12px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: -5px;
            right: -10px;
        }

        @media (max-width: 768px) {
            .header_body {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .navbar {
                margin-top: 10px;
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="header_body">
            <a href="index.php" class="company_Name">Medical Store</a>
            <nav class="navbar">
                <a href="index.php">Add Products</a>
                <a href="view_products.php">View Products</a>
                <a href="shop_products.php">Shopit</a>
                <a href="">Appoitment</a>
            </nav>
            <!-- Select Query -->
            <?php
            $select_product=mysqli_query($conn,'Select *from `cart`') or die('query failed');

            $row_count=mysqli_num_rows($select_product);
            ?>
            <a href="cart.php" class="cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-badge"> <?php echo $row_count ?> </span>
            </a>
        </div>
    </header>

</body>
</html>
