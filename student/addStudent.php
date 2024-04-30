<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project
?>

<?php

session_start();
//ensuring user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>Create a student</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="student.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <?php require_once('../indexMain/navTeacher.php'); ?>
    <h1>Create a student</h1>
    <?php
    require_once("../login/lib/utilities.php");
    if (isset($_POST['submit'])) {

        // create short variable names
        $studentName = test_input($_POST['studentName']);
        $studentPhone = test_input($_POST['studentPhone']);
        $studentEmail = test_input($_POST['studentEmail']);
        $studentAddress = test_input($_POST['studentAddress']);
        $parentName = test_input($_POST['parentName']);
        $parentContact = test_input($_POST['parentContact']);
        $classId = test_input($_POST['classId']);
        $password = test_input($_POST['password']);

        if (empty($studentName) || empty($studentPhone) || empty($studentEmail) || empty($studentAddress) ||
            empty($parentName) || empty($parentContact) || empty($classId) || empty($password)) {

            header("location: createStudent.php?error=empty");
            exit();

        }
        //Create DB object
        require_once('../login/lib/config.php');

        $studentName = $mysqli->real_escape_string($studentName);
        $studentPhone = $mysqli->real_escape_string($studentPhone);
        $studentEmail = $mysqli->real_escape_string($studentEmail);
        $studentAddress = $mysqli->real_escape_string($studentAddress);
        $parentName = $mysqli->real_escape_string($parentName);
        $parentContact = $mysqli->real_escape_string($parentContact);
        $classId = $mysqli->real_escape_string($classId);
        $password = $mysqli->real_escape_string($password);

        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.  Please try again later.";
            exit;
        }

        $query = "INSERT INTO student VALUES (
NULL,
'" . $studentName . "',
'" . $studentPhone . "',
'" . $studentEmail . "',
'" . $studentAddress . "',
'" . $parentName . "',
'" . $parentContact . "',
'" . $classId . "',
'" . sha1($password) . "'
)";

        // echo $query;
        $result = $mysqli->query($query);

        if ($result) {
            echo $mysqli->affected_rows . " student inserted into database. <a href='addStudent.php'>Add another?</a>";

            //Display student inventory
            $query = "SELECT * FROM student";
// Here we use our $mysqli object created above and run the query() method. We pass it our query from above.
            $result = $mysqli->query($query);

            $num_results = $result->num_rows;

            echo "<p>Number of students found: " . $num_results . "</p>";

            echo "<h2>School Student Rollcall</h2>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
            if ($num_results > 0) {
//  $result->fetch_all(MYSQLI_ASSOC) returns a numeric array of all the books retrieved with the query
                $students = $result->fetch_all(MYSQLI_ASSOC);
                echo "<table class='table table-bordered'><tr>";

//This dynamically retrieves header names
                foreach ($students[0] as $k => $v) {
                    echo "<th>" . $k . "</th>";
                }
                echo "</thead>";
                echo "<tbody>";
//Create a new row for each book
                foreach ($students as $student) {
                    echo "<tr>";

                    foreach ($student as $k => $v) {

                        echo "<td>" . $v . "</td>";

                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            $result->free();
            $mysqli->close();
        } else {
            echo "An error has occurred.  The item was not added. <a href='../indexMain/indexTeacher.php'>Try again?</a>";
        }

    } else {

        header("location:createStudent.php?error=noform");
        exit();

    }
    ?>

        <script>
            $(document).ready(function(){
                alert("Student has been created.");
            });
        </script>
</div>
</body>
</html>
