
<!DOCTYPE html>
<html>
    <head>
        <title>Users</title>
        <link rel="stylesheet" href="adminstyle.css">
    </head>
    <body>
        <?php
        require_once 'dbh.inc.php';

        $users = [];

        $query = "SELECT * FROM entity_users";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        if (isset($_POST['return'])) {
            header("location: adminpage.php");
            exit();
        }

        if (isset($_POST['update'])) {
            $passwords = $_POST['password'];
            $admin = $_POST['admin'];

            foreach ($passwords as $userID => $password) {
                $sql = "UPDATE entity_users SET userspwd = ? WHERE users_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "si", $password, $userID);
                $success = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            foreach ($admin as $userID => $adminStatus) {
                $sql = "UPDATE entity_users SET adminStat = ? WHERE users_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $adminStatus, $userID);
                $success = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            if ($success) {
                $message = "Update successful.";
            } else {
                $message = "Update failed. Error: " . mysqli_error($conn);
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>

        <div>
            <?php if (isset($message)) echo $message; ?>
        </div>

        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Admin Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <input type="text" name="name[]" value="<?php echo $user['usersname']; ?>" disabled>
                                <input type="hidden" name="userID[]" value="<?php echo $user['users_id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="password[<?php echo $user['users_id']; ?>]" value="<?php echo $user['userspwd']; ?>">
                            </td>
                            <td>
                                <select name="admin[<?php echo $user['users_id']; ?>]">
                                    <option value="0" <?php if ($user['adminStat'] == 0) echo 'selected'; ?>>False</option>
                                    <option value="1" <?php if ($user['adminStat'] == 1) echo 'selected'; ?>>True</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="update">Update</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button id="return" type="submit" name="return">Back</button>
        </form>
    </body>
</html>