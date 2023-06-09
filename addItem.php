<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['return'])) {
        header("location: adminPage.php");
        exit();
    }

    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $stmt = $conn->prepare("INSERT INTO entity_item (name, price, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $name, $price, $quantity);
    
    if ($stmt->execute()) {
        echo "Item added successfully.";
    } else {
        if ($stmt->errno == 1062) {
            echo "Duplicate entry error: An item with the same name already exists.";
        } else {
            echo "Error adding item: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Add Item</title>
    </head>
    <body>
        <h1>Add Item</h1>
        <form method="post" action="addItem.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>

            <input type="submit" value="Add Item">
        </form>

        <form method="post" action="addItem.php">
            <button type="submit" name="return">Back</button>
        </form>
    </body>
</html>
