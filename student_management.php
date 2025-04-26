<?php
session_start();
ob_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$conn = new mysqli("localhost", "root", "", "student_management_system");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['student_name'])) {
    $student_name = $_POST["student_name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $year_level = $_POST["year_level"];

    $sql = "INSERT INTO students (student_name, email, course, year_level) 
            VALUES ('$student_name', '$email', '$course', '$year_level')";

    if ($conn->query($sql) === TRUE) {
        $message = "Student added successfully!";
    } else {
        $message = "Failed to add student. Try again.";
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['current_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $email = $_SESSION['user']['email'];
    $result = $conn->query("SELECT password FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user['password'] === $current_password) {
        if ($new_password === $confirm_password) {
            $conn->query("UPDATE users SET password='$new_password' WHERE email='$email'");
            $password_message = "Password changed successfully!";
        } else {
            $password_message = "New passwords do not match.";
        }
    } else {
        $password_message = "Current password is incorrect.";
    }
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management</title>
    <script>
        function toggleAddStudentForm() {
            const form = document.getElementById("add-student-form");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        function toggleChangePasswordForm() {
            const form = document.getElementById("change-password-form");
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
        #add-product-form, #change-password-form {
            display: none;
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        #add-product-form input, #change-password-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #add-product-form input[type="submit"],
        #change-password-form input[type="submit"],
        #add-product-form input[type="button"],
        #change-password-form input[type="button"] {
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
        #add-product-form input[type="submit"]:hover,
        #change-password-form input[type="submit"]:hover,
        #add-product-form input[type="button"]:hover,
        #change-password-form input[type="button"]:hover {
            background-color: #c87e1b;
        }
    </style>
</head>
<body>
    <h2>Student Records</h2>
    <?php if (isset($message)): ?>
        <p style="color: lightgreen; text-align: center;"><?= $message ?></p>
    <?php endif; ?>
    <?php if (isset($password_message)): ?>
        <p style="color: lightgreen; text-align: center;"><?= $password_message ?></p>
    <?php endif; ?>

    <div class="button-container">
        <button onclick="toggleChangePasswordForm()">Change Password</button>
        <button onclick="toggleAddStudentForm()">Add Student</button>
        <button onclick="window.location.href='login.php';">Logout</button>
    </div>

    <!-- Password Change Form -->
    <div id="change-password-form">
        <h3>Change Password</h3>
        <form method="POST">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
            <label>New Password</label>
            <input type="password" name="new_password" required>
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>
            <input type="submit" value="Change Password">
            <input type="button" value="Cancel" onclick="toggleChangePasswordForm()">
        </form>
    </div>

    <!-- Add Student Form -->
    <div id="add-student-form">
        <h3>Add Student</h3>
        <form method="POST">
            <label>Student Name</label>
            <input type="text" name="student_name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Course</label>
            <input type="text" name="course" required>
            <label>Year Level</label>
            <input type="number" name="year_level" required>
            <input type="submit" value="Add Student">
            <input type="button" value="Cancel" onclick="toggleAddStudentForm()">
        </form>
    </div>

    <!-- Student Table -->
    <table>
        <tr>
            <th>Student Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Year Level</th>
            <th>Actions</th>
        </tr>
        <?php while ($student = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $student['student_name'] ?></td>
            <td><?= $student['email'] ?></td>
            <td><?= $student['course'] ?></td>
            <td><?= $student['year_level'] ?></td>
            <td class="action-buttons">
                <a href="edit_student.php?id=<?= $student['id'] ?>" class="edit">Edit</a>
                <a href="delete_student.php?id=<?= $student['id'] ?>" class="delete">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
