<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");
$conn = new mysqli("localhost", "root", "", "inventory_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the user's current data
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id='$user_id'");
    $user = $result->fetch_assoc();
    if (!$user) {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user specified.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $update_query = "UPDATE users SET 
                        first_name='$first_name', 
                        last_name='$last_name', 
                        email='$email', 
                        role='$role', 
                        username='$username', 
                        password='$password' 
                    WHERE id='$user_id'";

    if ($conn->query($update_query) === TRUE) {
        $message = "User updated successfully!";
    } else {
        $message = "Failed to update user. Try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #464c5c;
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], input[type="button"] {
            background-color: #de921f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #c87e1b;
        }
        .success-message, .error-message {
            text-align: center;
            margin-bottom: 20px;
        }
        .success-message {
            color: lightgreen;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>
    <?php if (isset($message)): ?>
        <div class="<?= strpos($message, 'successfully') !== false ? 'success-message' : 'error-message' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>
    <div class="form-container">
        <form method="POST">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" required>
            
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required>
            
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            </select>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?= $user['password'] ?>" required>
            
            <input type="submit" value="Update User">
            <input type="button" value="Cancel" onclick="window.location.href='user_management.php';">
        </form>
    </div>
</body>
</html>
