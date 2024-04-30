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
    <title>Index Student</title>
</head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/custom.css">
<link rel="stylesheet" href="indexMain.css">
<script>
    // script for confirming book deletion
    function confirmDelete(bookId) {
        var confirmDelete = confirm("Are you sure you want to delete this record?");
        if (confirmDelete) {
            window.location.href = 'delete.php?bookId=' + bookId;
        } else {
        }
    }
</script>

<body>
<div id="index-container">
    <!--    code to show nothing to a guest user-->
    <?php
    if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
//not logged in so see nothing here.
    } else {
//code to show to logged in user.
        $studentId = $_SESSION["studentId"];
        $studentName = $_SESSION["studentName"];
        $date = date_create("now", timezone_open("America/Halifax"));
        $dateString = date_format($date, "Y/m/d H:iP");
        $page = "home";
        require_once('navStudent.php');
        ?>
        <ul id="studentmenu" class="nav navbar-nav">
            <li><a href="../classes/classesStudent.php">My Class</a></li>
            <li><a href="../homework/homeworkStudent.php">My Homework</a></li>
            <li><a href="../gradebook/gradebook.php">My Gradebook</a></li>
        </ul>

    <?php } ?>


</div>

</body>
</html>