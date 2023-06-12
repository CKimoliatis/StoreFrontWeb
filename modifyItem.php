<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST["item_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $stmt = $conn->prepare("UPDATE entity_item SET name=?, price=?, quantity=? WHERE item_id=?");
    $stmt->bind_param("siii", $name, $price, $quantity, $item_id);

    if ($stmt->execute()) {
        echo "Item modified successfully.";
    } else {
        echo "Error modifying item: " . $conn->error;
    }

    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM entity_item");
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();

if (isset($_POST['return'])) {
    header("location: adminPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modify Items</title>
    </head>
    <body>
        <h1>Modify Items</h1>
        <table>
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php foreach ($items as $item) { ?>
                <tr>
                <form method="post" action="modifyItem.php">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <td><?php echo $item['item_id']; ?></td>
                    <td><input type="text" name="name" value="<?php echo $item['name']; ?>" required></td>
                    <td><input type="number" name="price" value="<?php echo $item['price']; ?>" required></td>
                    <td><input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required></td>
                    <td><input type="submit" value="Modify"></td>
                </form>
            </tr>
        <?php } ?>
    </table>
    <form method="post" action="modifyItem.php">
        <button type="submit" name="return">Back</button>
    </form>
</body>
</html>
