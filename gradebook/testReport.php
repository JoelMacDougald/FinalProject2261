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
$testName = $_SESSION['testSelected'];

$query5 = "SELECT * FROM student WHERE studentId = " . $studentId;
$result5 = $mysqli->query($query5);
$student = $result5->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM tests WHERE testName = '$testName'";
$result = $mysqli->query($query);
$test = $result->fetch_assoc();
$testId = $test['testId'];


$testTotal = 0;
$totalScore = 0;
?>
<!doctype html>
<html>
<head>
    <title>Test Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="gradebook.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="containerTestReport">
    <?php require_once('../indexMain/navStudent.php'); ?>
    <h4><strong><u><i>Test Report</i></u></strong></h4>
    <br>
    <h4>Charlottetown English Online School</h4>
    <br>
    <div class="col-xs-8">
        <table class="table" style="border-top: 3px solid #ccc;">
            <tbody>
            <tr>
                <?php
                echo '<td id="headerBlock"> Section: </td>';
                echo "<td>" . $sectionId . "</td>";
                echo '<td id="headerBlock">Student: </td>';
                foreach ($student as $name) {
                    echo "<td>" . $name['studentName'] . "</td>";
                };
                echo '<td id="headerBlock">Test Name: </td>';
                echo "<td>" . $testName . "</td>";
                ?>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="table" style="border-top: 3px solid #ccc;">
            <thead>
            <tr>
                <th id="headerBlock">Question</th>
                <th id="headerBlock">Correct Answer</th>
                <th id="headerBlock">Student Answer</th>
                <th id="headerBlock">Points</th>
                <th id="headerBlock">Feedback</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT * FROM questions WHERE testId = $testId";
            $result1 = $mysqli->query($query1);
            if ($result1 && $result1->num_rows > 0) {
                while ($question = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $question['questionText'] . "</td>";
                    $testTotal += $question['points'];
                    $questionId = $question['questionId'];

                    $query2 = "SELECT * FROM answers WHERE questionId = $questionId";
                    $result2 = $mysqli->query($query2);
                    if ($result2 && $result2->num_rows > 0) {
                        while ($answer = $result2->fetch_assoc()) {
                            echo "<td>" . $answer['answerText'] . "</td>";
                        }
                    }

                    $query3 = "SELECT * FROM studentanswers WHERE questionId = $questionId AND studentId = $studentId";
                    $result3 = $mysqli->query($query3);
                    $studentanswers = $result3->fetch_all(MYSQLI_ASSOC);
                    foreach ($studentanswers as $studentanswer) {
                        $totalScore += $studentanswer['pointsAwarded'];
                        echo "<td>" . $studentanswer['studentAnswer'] . "</td>";
                        echo "<td>" . $studentanswer['pointsAwarded'] . "</td>";
                        echo "<td>" . $studentanswer['feedback'] . "</td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
            </tbody>
        </table>
        <br>
        <table class="table" style="border-top: 3px solid #ccc;">
            <tbody>
            <tr>
                <td id="headerBlock">Score:</td>
                <?php echo "<td>" . $totalScore . " / " . $testTotal . "</td>" ?>
                <td id="headerBlock">Precentage:</td>
                <?php $percentage = $totalScore / $testTotal * 100;
                echo "<td>" . $percentage . "%</td>" ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
