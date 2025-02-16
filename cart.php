<?php include 'connect.php'; 
if(isset($_POST['update_product_quantity'])){
    $update_value=$_POST['update_quantity'];
    $update_id=$_POST['update_quantity_id'];
    $update_quantity_query=mysqli_query($conn,"update `cart` set quantity=$update_value where id=$update_id");
    if($update_quantity_query){
        header('location:cart.php');
    }
}
if(isset($_GET['remove'])){
    $remove_id=$_GET['remove'];
    mysqli_query($conn,"Delete from `cart` where id=$remove_id");
    header('location:cart.php');
}
if(isset($_GET['delete_all'])){
    mysqli_query($conn,"Delete from `cart`");
    header('location:cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --color1: #072227;
            --color2: #35858b;
            --color3: #4fbdba;
            --color4: #aefeff;
            --black: #000;
            --white: #fff;
            --lightgray: #f0f0f0;
            --red: rgb(238, 62, 62);
        }

        body {
            background-color: var(--lightgray);
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: var(--color1);
            padding-bottom: 20px;
        }

        .shopping_cart table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .shopping_cart th, .shopping_cart td {
            padding: 12px;
            font-size: 1rem;
            border: 1px solid var(--lightgray);
        }

        .shopping_cart thead th {
            background-color: var(--color2);
            color: var(--white);
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }

        .quantity_box input[type="number"] {
            width: 45px;
            padding: 5px;
            text-align: center;
            font-size: 0.9rem;
        }

        .quantity_box input[type="submit"] {
            background-color: var(--color1);
            color: var(--white);
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .quantity_box input[type="submit"]:hover {
            background-color: var(--color3);
        }

        .table_bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--color1);
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .bottom_btn {
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: var(--black);
            background-color: var(--color4);
            transition: 0.3s;
        }

        .bottom_btn:hover {
            background-color: var(--color3);
            color: var(--white);
        }

        .delete_all_btn {
            display: block;
            text-align: center;
            width: 180px;
            background-color: var(--red);
            color: var(--white);
            font-size: 1rem;
            padding: 10px;
            border-radius: 5px;
            margin: 20px auto;
            transition: 0.3s;
        }

        .delete_all_btn:hover {
            background-color: darkred;
        }

        .delete_all_btn .fa-trash {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .table_bottom {
                flex-direction: column;
                text-align: center;
            }
            .bottom_btn {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <?php include 'header.php'; ?>
    
    <div class="container">
        <section class="shopping_cart">
            <h1 class="heading">MY CART</h1>
            <table>
                <?php
                $select_cart_product=mysqli_query($conn,"SELECT * FROM `cart`");
                $num=1;
                $grand_total=0;
                if(mysqli_num_rows($select_cart_product)>0){
                    echo " <thead>
                    <th>Sl No</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </thead>
                <tbody>";
                while($fetch_cart_products = mysqli_fetch_assoc($select_cart_product)){
                    ?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td><?php echo $fetch_cart_products['name'];?></td>
                        <td>
                            <img src="images/<?php echo $fetch_cart_products['image'];?>" alt="<?php echo $fetch_cart_products['name'];?>">
                        </td>
                        <td><?php echo $fetch_cart_products['price'];?> Taka</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $fetch_cart_products['id'];?>" name="update_quantity_id">
                                <div class="quantity_box">
                                    <input type="number" min="1" value="<?php echo $fetch_cart_products['quantity'];?>" name="update_quantity">
                                    <input type="submit" value="Update" name="update_product_quantity">
                                </div>
                            </form>
                        </td>
                        <td><?php echo $subtotal=($fetch_cart_products['price']*$fetch_cart_products['quantity']);?> Taka</td>
                        <td>
                            <a href="cart.php?remove=<?php echo $fetch_cart_products['id'];?>" onclick="return confirm('Are you sure?')" style="color: red;">
                                <i class="fas fa-trash"></i> REMOVE
                            </a>
                        </td>
                    </tr>
                <?php
                $grand_total += $subtotal;
                $num++;
                }
                }
                else {
                    echo "<tr><td colspan='7'>No products in cart</td></tr>";
                }
                ?>
                </tbody>
            </table>

            <div class="table_bottom">
                <a href="shop_products.php" class="bottom_btn">Continue Shopping</a>
                <h3 class="bottom_btn">Grand Total: <?php echo $grand_total; ?> Taka</h3>
                <a href="checkout.php" class="bottom_btn">Proceed To Check Out</a>
            </div>

            <a href="cart.php?delete_all" class="delete_all_btn">
                <i class="fas fa-trash"></i> Delete All
            </a>
        </section>
    </div>
</body>
</html>
