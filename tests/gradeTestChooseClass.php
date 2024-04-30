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
    <title>Select Class</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="tests.css">
</head>
<body>
<div id="containerChooseTest">
    <?php require_once('../indexMain/navTeacher.php'); ?>
    <h1>Choose the Class to grade.</h1>

    <br>

    <?php require_once('../login/lib/config.php'); ?>

    <form id="chooseForm" method="get" action="testClassChooseTestStudent.php">

        <select id="classSelected" name="classSelected">
            <?php
            $query = "SELECT * FROM classes";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["classId"] . '">' . $row["classId"] . '</option>';
                }
            } else {
                echo '<option value="">No sections found</option>';
            }
            ?>
        </select>
        <br>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>


</div>


</body>
</html>



