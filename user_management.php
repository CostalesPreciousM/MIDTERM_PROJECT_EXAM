<?php
session_start();
ob_start();
if (!isset($_SESSION['user'])) header("Location: login.php");
$conn = new mysqli("localhost", "root", "", "inventory_system");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $role = trim($_POST["role"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($username) && !empty($password)) {

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, role, username, password) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $role, $username, $password);

        if ($stmt->execute()) {
            $message = "User added successfully!";
        } else {
            $message = "Failed to add user. Try again.";
        }
        $stmt->close();
    } else {
        $message = "All fields are required. Please fill out the form.";
    }
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script>
        function toggleAddUserForm() {
            const form = document.getElementById("add-user-form");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
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
        .button-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .button-container button {
            background-color: #de921f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-left: 10px;
        }
        .button-container button:hover {
            background-color: #c87e1b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            color: #000;
            border-radius: 5px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #de921f;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons a {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: white;
        }
        .action-buttons .edit {
            background-color: #5cb85c;
        }
        .action-buttons .edit:hover {
            background-color: #4cae4c;
        }
        .action-buttons .delete {
            background-color: #d9534f;
        }
        .action-buttons .delete:hover {
            background-color: #c9302c;
        }
        #add-user-form {
            display: none;
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        #add-user-form input, #add-user-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #add-user-form input[type="submit"], #add-user-form input[type="button"] {
            background-color: #de921f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        #add-user-form input[type="submit"]:hover, #add-user-form input[type="button"]:hover {
            background-color: #c87e1b;
        }
    </style>
</head>
<body>
    <h2>User Management</h2>
    <?php if (isset($message)): ?>
        <p style="color: lightgreen; text-align: center;"><?= $message ?></p>
    <?php endif; ?>
    <div class="button-container">
        <button onclick="toggleAddUserForm()">Add User</button>
        <button onclick="window.location.href='login.php';">Logout</button>
        <button onclick="window.location.href='grade_system.php';">Grades</button>
    </div>

    <div id="add-user-form">
        <h3>Add User</h3>
        <form method="POST">
            <label>First Name</label>
            <input type="text" name="first_name" required>
            <label>Last Name</label>
            <input type="text" name="last_name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Role</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="submit" value="Create User">
            <input type="button" value="Cancel" onclick="toggleAddUserForm()">
        </form>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Username</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $user['first_name'] . " " . $user['last_name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['role'] ?></td>
            <td><?= $user['username'] ?></td>
            <td><?= $user['password'] ?></td>
            <td class="action-buttons">
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="edit">Edit</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="delete">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
