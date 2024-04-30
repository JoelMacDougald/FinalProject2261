<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project
session_start();

require_once('../indexMain/navTeacher.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
</head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="student.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<body>
<div id="containerUpdateStudent">
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

    <div id="studentForm" class="updateStudent-form">
        <form action="updateStudent.php" method="post">
            <fieldset  class="scheduler-border">
                <legend  class="scheduler-border">Update Student</legend>
                <?php




                ?>
                <!--capturing info of book to add-->
                <div class="form-group">
                    <label for="studentName">Student Name:</label>
                    <input type="text" class="form-control" id="studentName" name="studentName">
                </div>
                <div class="form-group">
                    <label for="studentPhone">Student Phone</label>
                    <input type="text" class="form-control" id="studentPhone" name="studentPhone">
                </div>
                <div class="form-group">
                    <label for="studentEmail">Student Email</label>
                    <input type="text" class="form-control" id="studentEmail" name="studentEmail">
                </div>
                <div class="form-group">
                    <label for="studentAddress">Student Address</label>
                    <input type="text" class="form-control" id="studentAddress" name="studentAddress">
                </div>
                <div class="form-group">
                    <label for="parentName">Parent Name</label>
                    <input type="text" class="form-control" id="parentName" name="parentName">
                </div>
                <div class="form-group">
                    <label for="parentContact">Parent Contact</label>
                    <input type="text" class="form-control" id="parentContact" name="parentContact">
                </div>
                <div class="form-group">
                    <label for="classId">Class ID</label>
                    <input type="text" class="form-control" id="classId"  name="classId">
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="text" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Update Student</button>
                </div>

            </fieldset>
        </form>
        <?php }?>
    </div>
</body>
</html>