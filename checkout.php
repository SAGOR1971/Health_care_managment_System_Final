<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #2c6975;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2c6975;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 10px auto;
            display: block;
        }
        .btn:hover {
            background: #1b4d5a;
        }
        .invoice {
            display: none;
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price (Taka)</th>
                    <th>Quantity</th>
                    <th>Total (Taka)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                $grand_total = 0;
                while ($row = mysqli_fetch_assoc($select_cart)) {
                    $subtotal = $row['price'] * $row['quantity'];
                    $grand_total += $subtotal;
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$subtotal} Taka</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <h2 style="text-align:center;">Grand Total: <span><?php echo $grand_total; ?> Taka</span></h2>
        <a href="#" class="btn" onclick="generateInvoice()">Print Invoice</a>
    </div>

    <!-- Invoice Section (Hidden until Print is Clicked) -->
    <div class="invoice" id="invoice">
        <h2 style="text-align:center;">Invoice</h2>
        <p><strong>Customer Name:</strong> [Your Name]</p>
        <p><strong>Date:</strong> <?php echo date("Y-m-d"); ?></p>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price (Taka)</th>
                    <th>Quantity</th>
                    <th>Total (Taka)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                while ($row = mysqli_fetch_assoc($select_cart)) {
                    $subtotal = $row['price'] * $row['quantity'];
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$subtotal} Taka</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <h2 style="text-align:center;">Grand Total: <span><?php echo $grand_total; ?> Taka</span></h2>
    </div>

    <script>
        function generateInvoice() {
            var invoice = document.getElementById("invoice");
            invoice.style.display = "block";
            window.print();
            invoice.style.display = "none";
        }
    </script>
</body>
</html>
