<?php
include "grade_system.php"; 

$grade_id = "";
$student_name = "";
$email = "";
$course = "";
$year_level = "";
$grades = "";
$subject_id = "";



if (isset($_GET["student_id"])) {
    $id = $_GET["student_id"];

    $sql = "SELECT * FROM students WHERE student_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $grade_id = $_POST["grade_id"];
        $student_name = $student["student_name"];
        $email = $student["email"];
        $course = $student["course"];
        $year_level = $student["year_level"];
        $grades = $_POST["grades"];
        $subject_id = $_POST["subject_id"];

    } else {
        die("Student not found");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $grade_id = $_POST["grade_id"];
    $student_name = $student["student_name"];
    $email = $student["email"];
    $course = $student["course"];
    $year_level = $student["year_level"];
    $grades = $_POST["grades"];
    $subject_id = $_POST["subject_id"];


    $sql = "UPDATE grades SET
        student_name = ?, email = ?, course = ?, year_level = ?, grades = ?, subject_id = ?
        WHERE grade_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $student_name, $email, $course, $year_level, $grades, $subject_id);

    if ($stmt->execute()) {
        echo "Student updated successfully!";
    } else {
        die("Error updating student");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"],
        input[type="button"] {
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

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #c87e1b;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <h2>Edit Student</h2>
    <div class="form-container">
        <form action="edit_student.php" method="POST">
            <label for="student_name">Student Name</label>
            <input type="text" name="student_name" required value="<?= $student_name; ?>">

            <label for="email">Email</label>
            <input type="email" name="email" required value="<?= $email; ?>">

            <label for="course">Course</label>
            <input type="text" name="course" required value="<?= $course; ?>">

            <label for="year_level">Year Level</label>
            <input type="number" name="year_level" min="1" max="5" required value="<?= $year_level; ?>">

            <input type="hidden" name="id" value="<?= $student_id; ?>">

            <div class="button-container">
                <input type="submit" value="Update Student">
                <input type="button" value="Back to Student Management"
                    onclick="window.location.href='student_management.php';">
            </div>
        </form>
    </div>
</body>

</html>