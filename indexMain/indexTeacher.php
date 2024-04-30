<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

//Start the session
session_start();
// Ensuring user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Index Teacher</title>
</head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/custom.css">
<link rel="stylesheet" href="indexMain.css">

<body>
<div id="index-container">

    <?php
    if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
//not logged in so see nothing here.
    } else {
//code to show to logged in user.
        $userName = $_SESSION["teacherName"];
        $date = date_create("now", timezone_open("America/Halifax"));
        $dateString = date_format($date, "Y/m/d H:iP");
        $page = "home";
        require_once('navTeacher.php');
        ?>
        <ul id="teachermenu" class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Students <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../student/createStudent.php">Create Student</a></li>
                    <li><a href="../student/updateStudent.php">Update Student</a></li>
                    <li><a href="../student/deleteStudent.php">Delete Student</a></li>
                </ul>
            </li>
            <li><a href="../classes/classesTeacher.php">Classes</a></li>
            <li><a href="../homework/homeworkTeacher.php">Homework</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tests <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../tests/createTest.php">Create Test</a></li>
                    <li><a href="../tests/updateTest.php">Update Test</a></li>
                    <li><a href="../tests/gradeTestChooseClass.php">Grade Test</a></li>
                    <li><a href="../tests/deleteTest.php">Delete Test</a></li>
                </ul>
            </li>
        </ul>


    <?php } ?>


</div>

</body>
</html>