<?php
include "grade_system.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = $_POST["student_name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $year_level = $_POST["year_level"];
    $grades = $_POST["grades"];
    $subject_id = $_POST["subject_id"];


    $sql = "INSERT INTO grades (student_name, email, course, year_level, grades, subject_id) 
            VALUES ('$student_name', '$email', '$course', '$year_level', $grades, $subject_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Student Added Successfully";
    } else {
        echo "Failed to add student, try again";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>

<body>
    <form action="add_student.php" method="POST">
        <label for="">Student Name</label>
        <input type="text" name="student_name" required>
        <br><br>

        <label for="">Email</label>
        <input type="email" name="email" required>
        <br><br>

        <label for="">Course</label>
        <input type="text" name="course" required>
        <br><br>

        <label for="">Year Level</label>
        <input type="text" name="year_level"  required>
        <br><br>

        <label for="">Grades</label>
        <input type="number" name="grades" min="1" max="5" required>
        <br><br>
        <label for="">Subject ID</label>
        <input type="number" name="subject_id" min="1" max="5" required>
        <br><br>


        <input type="submit" value="Add Student">
        <input type="button" value="Back to Student Management"
            onclick="window.location.href='student_management.php';">
    </form>
</body>

</html>