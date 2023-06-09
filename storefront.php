<?php
session_start();
$userid = $_SESSION['usersid'];
$username = $_SESSION['usersname'];

require_once 'dbh.inc.php';

$query = 'SELECT item_id, name, price, quantity FROM entity_item';
$result = $conn->query($query);

if (!$result) {
    die('Error executing the query: ' . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
        $itemId = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        $insertQuery = "INSERT INTO entity_cart (user_id, item_id, quantity) VALUES ('$userid', '$itemId', '$quantity')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Item added to cart successfully.";
        } else {
            echo "Error adding item to cart: " . $conn->error;
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Storefront</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 20px;
            }

            h1 {
                text-align: center;
                margin-bottom: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f5f5f5;
            }

            .add-to-cart-btn {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
            }

            .add-to-cart-btn:hover {
                background-color: #45a049;
            }

            .logout-btn {
                background-color: #f44336;
                color: #fff;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
                float: right;
            }

            .logout-btn:hover {
                background-color: #d32f2f;
            }
        </style>
    </head>
    <body>
        <h1>Storefront</h1>

        <form method="POST" action="">
            <button class="logout-btn" type="submit" name="logout">Logout</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="cart.php"><button>Go to Cart</button></a>
    </body>
</html>
