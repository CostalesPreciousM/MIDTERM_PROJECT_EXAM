<?php
include "user_management.php";

$first_name = "";
$last_name = "";
$email = "";
$password = "";
$username = "";
$role = "user";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $username = $_POST["username"];
    $role = $_POST["role"];

    $sql = "INSERT INTO users (first_name, last_name, email, username, password, role) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $username, $password, $role);

    if ($stmt->execute()) {
        echo "New user added successfully";
    } else {
        echo "Error adding user: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>

<body>
    <h1>Add New User</h1>
    <form action="add_user.php" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" required value="<?= $first_name; ?>">
        <br><br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" required value="<?= $last_name; ?>">
        <br><br>
        <label for="email">Email</label>
        <input type="email" name="email" required value="<?= $email; ?>">
        <br><br>
        <label for="username">Username</label>
        <input type="text   " name="username" required value="<?= $username; ?>">
        <br><br>
        <label for="password">Password</label>
        <input type="password" name="password" required value="<?= $password; ?>">
        <br><br>
        <label for="role">Role</label>
        <select name="role" id="role" required>
            <option value="user" <?= $role == 'user' ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?= $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <br><br>

        <input type="submit" value="Add User">
        <input type="button" value="Back to User Management" onclick="window.location.href='user_management.php';">
    </form>

</body>

</html>