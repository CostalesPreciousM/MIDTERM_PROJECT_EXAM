<?php
session_start();
ob_start();
if (!isset($_SESSION['user'])) header("Location: login.php");

$conn = new mysqli("localhost", "root", "", "student_management_system");

// Handle adding a grade
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['student_id'])) {
    $grade_id = $_POST["grade_id"];
    $student_name = $_POST["student_name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $year_level = $_POST["year_level"];
    $grades = $_POST["grades"];
    $subject_id = $_POST["subject_id"];
    $student_id = $_POST["student_id"];

    $sql = "INSERT INTO grades (grade_id, course, grades, email, year_level, student_name, subject_id, student_id) 
            VALUES ('$student_id', '$course', '$grades', '$grade_id', '$email', '$year_level','$student_name', '$subject_id',)";

    if ($conn->query($sql) === TRUE) {
        $message = "Grade added successfully!";
    } else {
        $message = "Failed to add grade. Try again.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Grading System</title>
    <style>
    
    </style>
    <script>
        function toggleAddGradeForm() {
            const form = document.getElementById("add-grade-form");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h2>Student Grading System</h2>
    <?php if (isset($message)): ?>
        <p style="color: lightgreen; text-align: center;"><?= $message ?></p>
    <?php endif; ?>
    
    <div class="button-container">
        <button onclick="toggleAddGradeForm()">Add Grade</button>
        <button onclick="window.location.href='user_management.php';">Users</button>
        <button onclick="window.location.href='login.php';">Logout</button>
    </div>


    <div id="add-grade-form" style="display:none;">
        <h3>Add Grade</h3>
        <form method="POST">
            <label>Select Student</label>
            <select name="student_id" required>
                <?php while ($student = $students_result->fetch_assoc()): ?>
                    <option value="<?= $student['id'] ?>"><?= $student['student_name'] ?></option>
                <?php endwhile; ?>
            </select>
            <label>Course</label>
            <input type="text" name="course" required>
            <label>Grade</label>
            <input type="text" name="grade" required>
            <input type="submit" value="Add Grade">
            <input type="button" value="Cancel" onclick="toggleAddGradeForm()">
        </form>
    </div>


    <h3>Student Grades</h3>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Course</th>
            <th>Grade</th>
        </tr>
        <?php while ($grade = $grades_result->fetch_assoc()): ?>
        <tr>
            <td><?= $grade['student_name'] ?></td>
            <td><?= $grade['course'] ?></td>
            <td><?= $grade['grade'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
