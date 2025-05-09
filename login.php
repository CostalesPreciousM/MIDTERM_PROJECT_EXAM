<?php
session_start();
$conn = new mysqli("localhost", "root", "", "student_management_system 3");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errormessage = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
    $user = $result->fetch_assoc();
    if (isset($user['password'])) {
        $_SESSION['user'] = $user; 

        if ($user['role'] === 'admin') {
            header("Location: user_management.php"); 
        } else {
            header("Location: student_management.php"); 
        }
        exit();
    } else {
        $errormessage = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <script src="validation.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #464c5c;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 98%;
            padding: 10px;
            background-color: #de921f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>LOGIN</h1>
    <?php if (!empty($errormessage)): ?>
        <div class="error-message"><?php echo $errormessage; ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        Email:
        <input type="text" name="email" required>
        <br>
        Password:
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
