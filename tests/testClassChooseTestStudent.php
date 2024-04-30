<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project
?>

<?php

session_start();
// Ensuring user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}

$class = $_GET['classSelected'];
?>
<!doctype html>
<html>
<head>
    <title>Grade Test Class <?php echo $class; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="tests.css">
</head>
<body>
<div id="containerGradeTest">
    <?php require_once('../indexMain/navTeacher.php');

    require_once('../login/lib/config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $selectedTestName = $_POST['testName'];
        $selectedStudentName = $_POST['studentName'];

        // Redirect to the next page with the captured values
        header("Location: gradeTest.php?testName=" . urlencode($selectedTestName) . "&studentName=" . urlencode($selectedStudentName));
        exit;
    }

    echo "<h2>Choose the Test</h2>";
    $query = "SELECT * FROM tests WHERE classID = '$class'";
    $result = $mysqli->query($query);

    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
    echo '<select name="testName">';
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["testName"] . '">' . $row["testName"] . '</option>';
        }
    } else {
        echo '<option value="">No tests found</option>';
    }
    echo '</select>';


    echo "<h2>Choose the student</h2>";
    $query0 = "SELECT DISTINCT studentId FROM studentanswers";
    $result0 = $mysqli->query($query0);

    echo '<select name="studentName">';
    if ($result0->num_rows > 0) {
        // Output data of each row
        while($row = $result0->fetch_assoc()) {
            $studentId = $row["studentId"];
            // Search for student name using student ID
            $queryStudent = "SELECT studentName FROM student WHERE studentId = '$studentId'";
            $resultStudent = $mysqli->query($queryStudent);
            if ($resultStudent->num_rows > 0) {
                while ($rowStudent = $resultStudent->fetch_assoc()) {
                    echo '<option value="' . $rowStudent["studentName"] . '">' . $rowStudent["studentName"] . '</option>';
                }
            }
            $resultStudent->free();
        }
    } else {
        echo '<option value="">No students found</option>';
    }
    echo '</select>';

    echo '<input type="submit" name="submit" value="Submit">';
    echo '</form>';

    $result->free();
    $result0->free();
    $mysqli->close();
    ?>
</div>
</body>
</html>

