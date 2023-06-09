<?php
session_start();
$userid = $_SESSION['usersid'];
$username = $_SESSION['usersname'];

require_once 'dbh.inc.php';

$query = "SELECT c.item_id, i.name, i.price, c.quantity 
          FROM entity_cart AS c 
          INNER JOIN entity_item AS i ON c.item_id = i.item_id 
          WHERE c.user_id = '$userid'";
$result = $conn->query($query);

if (!$result) {
    die('Error executing the query: ' . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $itemId = $_POST['item_id'];
        $newQuantity = intval($_POST['quantity']); // Convert quantity to integer

        if ($newQuantity == 0) {
            $deleteQuery = "DELETE FROM entity_cart WHERE user_id = '$userid' AND item_id = '$itemId'";
            if ($conn->query($deleteQuery) === TRUE) {
                echo "Item removed from cart successfully.";
                header("Location: cart.php");
                exit();
            } else {
                echo "Error removing item from cart: " . $conn->error;
            }
        } else {
            $updateQuery = "UPDATE entity_cart SET quantity = $newQuantity WHERE user_id = '$userid' AND item_id = '$itemId'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Item quantity updated successfully.";
                header("Location: cart.php");
                exit();
            } else {
                echo "Error updating item quantity: " . $conn->error;
            }
        }
    } elseif (isset($_POST['remove_item_id'])) {
        $itemId = $_POST['remove_item_id'];

        $deleteQuery = "DELETE FROM entity_cart WHERE user_id = '$userid' AND item_id = '$itemId'";
        if ($conn->query($deleteQuery) === TRUE) {
            echo "Item removed from cart successfully.";
            header("Location: cart.php");
            exit();
        } else {
            echo "Error removing item from cart: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cart</title>
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

            .update-quantity-btn {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
            }

            .update-quantity-btn:hover {
                background-color: #45a049;
            }

            .remove-item-btn {
                background-color: #f44336;
                color: #fff;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
            }

            .remove-item-btn:hover {
                background-color: #d32f2f;
            }

            .back-btn {
                background-color: #4285F4;
                color: #fff;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
            }

            .back-btn:hover {
                background-color: #3367D6;
            }

            .total-row {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <h1>Cart</h1>

        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $combinedItems = array();
                while ($row = $result->fetch_assoc()) {
                    $itemId = $row['item_id'];
                    $itemName = $row['name'];
                    $itemPrice = $row['price'];
                    $itemQuantity = $row['quantity'];
                    $subtotal = $itemPrice * $itemQuantity;

                    if (isset($combinedItems[$itemId])) {
                        $combinedItems[$itemId]['quantity'] += $itemQuantity;
                        $combinedItems[$itemId]['subtotal'] += $subtotal;
                    } else {
                        $combinedItems[$itemId] = array(
                            'name' => $itemName,
                            'price' => $itemPrice,
                            'quantity' => $itemQuantity,
                            'subtotal' => $subtotal
                        );
                    }
                }

                foreach ($combinedItems as $itemId => $item) {
                    ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="item_id" value="<?php echo $itemId; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0">
                                <button class="update-quantity-btn" type="submit" name="update_quantity">Update</button>
                            </form>
                        </td>
                        <td>$<?php echo $item['subtotal']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="remove_item_id" value="<?php echo $itemId; ?>">
                                <button class="remove-item-btn" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }

                $total = 0;
                foreach ($combinedItems as $item) {
                    $total += $item['subtotal'];
                }
                ?>
                <tr class="total-row">
                    <td colspan="3"></td>
                    <td>Total:</td>
                    <td>$<?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>

        <br>
        <form action="storefront.php">
            <button class="back-btn" type="submit">Back to Storefront</button>
        </form>
    </body>
</html>
