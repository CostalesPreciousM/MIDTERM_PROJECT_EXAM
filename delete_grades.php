<?php
include "grade_system.php";



if (isset($_GET["grade_id"])) {
    $id = $_GET["grade_id"];

    if (isset($_POST["confirm"])) {


        if ($_POST["confirm"] === "no") {
            header("Location: grade_system.php");
        } else if ($_POST["confirm"] === "yes") {
            $sql = "DELETE FROM products WHERE grade_id =?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {

                header("Location: grade_management.php");
            } else {
                echo "Error deleting Grade!";
            }
        }
    }
} else {
    die("user not found");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Are you sure you want to delete the Grade from the records?</h1>

    <form method="POST">
        <button type="submit" name="confirm" value="yes">Yes, Delete</button>
        <button type="submit" name="confirm" value="no">No, Cancel</button>

    </form>
</body>

</html>