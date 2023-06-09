<?php
if (isset($_POST['logout'])) {
            session_destroy();
            header("location: index.php");
            exit();
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Page</h1>
    <button onclick="location.href='userPage.php'">User Page</button>
    <button onclick="location.href='modifyItem.php'">Modify Items</button>
    <button onclick="location.href='addItem.php'">Add Item</button>
    <form method="post" action="">
            <button id="submit" type="submit" name="logout">Log out</button>
    </form>
</body>
</html>
