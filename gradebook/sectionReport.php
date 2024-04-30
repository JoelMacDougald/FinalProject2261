<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}
require_once('../login/lib/config.php');


$studentId = $_SESSION['studentId'];
$sectionId = $_SESSION['sectionId'];


$date = date_create("now", timezone_open("America/Halifax"));
$dateString = date_format($date, "Y/m/d");

//query for student - to get name
$query1 = "SELECT * FROM student WHERE studentId = " . $studentId;
$result1 = $mysqli->query($query1);
$student = $result1->fetch_all(MYSQLI_ASSOC);

//query for homework for the section
$query2 = "SELECT * FROM homework WHERE sectionId = '" . $sectionId . "' AND studentId = " . $studentId;

$result2 = $mysqli->query($query2);
$homeworks = $result2->fetch_all(MYSQLI_ASSOC);

// query for the tests for the section
$query3 = "SELECT * FROM tests WHERE sectionId = '$sectionId'";
$result3 = $mysqli->query($query3);
$tests = $result3->fetch_all(MYSQLI_ASSOC);

// query for the student's grade on the tests

?>
<!doctype html>
<html>
<head>
    <title>Section Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="gradebook.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>


<div id="containerSectionReport" >

    <?php
    require_once('../indexMain/navStudent.php');
    ?>
    <h4><strong><u><i>Section Report</i></u></strong></h4>
    <br>
    <h4>Charlottetown English Online School</h4>

    <br>
<div class="col-xs-8">
    <table class="table" style="border-top: 3px solid #ccc;">
        <tbody>

        <tr>
            <?php


            echo '<td id="headerBlock">Section: </td>';
            echo "<td>" .$sectionId. "</td>";
            echo '<td id="headerBlock">Student: </td>';
           foreach ($student as $name)
           {
            echo "<td>" . $name['studentName'] ."</td>";
           };
            echo '<td id="headerBlock">Date: </td>';
            echo "<td>" .$dateString."</td>";
            ?>
        </tr>
        </tbody>
    </table>


    <br>
    <table class="table" style="border-top: 3px solid #ccc;">
        <tr>
            <th colspan="2" id="headerBlock">Attendance</th>
        </tr>
        <tr>
            <td id="headerBlock">Classes Attended</td>
            <td id="headerBlock">Classes Held</td>
        </tr>
        <tr>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <th colspan="2" id="headerBlock">Homework</th>
        </tr>
        <tr>
            <td id="headerBlock">Homework Name</td>
            <td id="headerBlock">Assessment</td>
        </tr>

            <?php foreach ($homeworks as $homework)
            {
                echo "<tr>";
            echo "<td>" . $homework['homeworkId'] ."</td>";
                echo "<td>" . $homework['homeworkAssessment'] ."</td>";
                echo "</tr>";
            };
            ?>

        <tr>
            <th colspan="2" id="headerBlock">Tests</th>
        </tr>
        <tr>
            <td id="headerBlock">Test</td>
            <td id="headerBlock">Grade</td>
        </tr>

        <?php
        foreach ($tests as $test) {
            echo "<tr>";
            echo "<td>" . $test['testName'] . "</td>";

            $query4 = "SELECT * FROM studenttests WHERE testId = '{$test['testId']}' AND studentId = '$studentId'";
            $result4 = $mysqli->query($query4);
            $studentTestGrade = $result4->fetch_assoc();

            if ($studentTestGrade) {
                echo "<td>" . $studentTestGrade['grade'] . "</td>";
            } else {
                echo "<td>No Grade</td>";
            }
            echo "</tr>";
        }
        ?>


    </table>
    <br>

</div>
</div>

</body>
</html>