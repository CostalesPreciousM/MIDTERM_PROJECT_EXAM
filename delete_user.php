<?php
include "user_management.php";

$conn = new mysqli("localhost", "root", "", "inventory_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user'])) {
    die("You must be logged in to delete users.");
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }


    if ($_SESSION['user']['role'] == 'admin' && $_SESSION['user']['id'] == $user['id']) {
        die("Admins cannot delete their own account.");
    }


    if ($_SESSION['user']['id'] == $user['id'] || $_SESSION['user']['role'] == 'admin') {
        if (isset($_POST["confirm"])) {
            if ($_POST["confirm"] === "no") {
                header("Location: index.php");
                exit();
            } else if ($_POST["confirm"] === "yes") {
                $sql = "DELETE FROM users WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    header("Refresh:0; url=user_management.php");
                    exit();
                } else {
                    echo "Error deleting record!";
                }
            }
        }
    } else {
        die("You don't have permission to delete this user.");
    }
} else {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
    <h1>Are you sure you want to delete this user?</h1>

    <form method="POST">
        <button type="submit" name="confirm" value="yes">Yes, Delete</button>
        <input type="button" value="No, Go Back" onclick="window.location.href='user_management.php';">
    </form>
</body>
</html>
