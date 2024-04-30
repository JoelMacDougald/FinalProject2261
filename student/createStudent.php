<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}
require_once('../indexMain/navTeacher.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
</head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="student.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<body>
<div id="containerCreateStudent">
    <?php
    if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
//not logged in so see nothing here.
    } else {
    //code to show to logged in user.
    $userName = $_SESSION["teacherName"];
    $date = date_create("now", timezone_open("America/Halifax"));
    $dateString = date_format($date, "Y/m/d H:iP");
    $page = "home";

    ?>

    <div id="studentForm" class="newStudent-form">
        <form action="addStudent.php" method="post">
            <fieldset  class="scheduler-border">
                <legend  class="scheduler-border">Create Student</legend>
                <?php
                //verifying all fields are completed
                $msg = "";

                if (isset($_GET["error"])) {

                    if($_GET["error"] == 'empty') {

                        $msg = "You have not entered all the required details.";
                    }else if($_GET["error"] == 'db') {

                        $msg = "DB error.Student not added.";
                    }else if($_GET["error"] == 'noform') {

                        $msg = "You must fill out a new student form.";
                    }

                }
                echo "<p class='error'>$msg</p>";
                ?>
                <!--capturing info of book to add-->
                <div class="form-group">
                    <label for="studentName">Student Name:</label>
                    <input type="text" class="form-control" id="studentName" placeholder="Enter student's full name" name="studentName">
                </div>
                <div class="form-group">
                    <label for="studentPhone">Student Phone</label>
                    <input type="text" class="form-control" id="studentPhone" placeholder="Enter student's phone" name="studentPhone">
                </div>
                <div class="form-group">
                    <label for="studentEmail">Student Email</label>
                    <input type="text" class="form-control" id="studentEmail" placeholder="Enter student's email" name="studentEmail">
                </div>
                <div class="form-group">
                    <label for="studentAddress">Student Address</label>
                    <input type="text" class="form-control" id="studentAddress" placeholder="Enter student's address" name="studentAddress">
                </div>
                <div class="form-group">
                    <label for="parentName">Parent Name</label>
                    <input type="text" class="form-control" id="parentName" placeholder="Enter parent's name" name="parentName">
                </div>
                <div class="form-group">
                    <label for="parentContact">Parent Contact</label>
                    <input type="text" class="form-control" id="parentContact" placeholder="Enter parent's contact info" name="parentContact">
                </div>
                <div class="form-group">
                    <label for="classId">Class ID</label>
                    <input type="text" class="form-control" id="classId" placeholder="Enter student's class ID" name="classId">
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="text" class="form-control" id="password" placeholder="Enter student's password" name="password">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Create Student</button>
                </div>

            </fieldset>
        </form>
        <?php }?>
</div>
</body>
</html>
