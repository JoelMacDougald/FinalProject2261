
<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

session_start();
// Ensuring user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("Location: ../indexMain/indexTeacher.php?message=notLoggedIn");
    exit;
}
$testGradePercent = 0;
require_once('../login/lib/config.php');

if(isset($_GET['testName']) && isset($_GET['studentName'])) {
    $selectedTestName = $_GET['testName'];
    $selectedStudentName = $_GET['studentName'];

    $query0 = "SELECT studentId FROM student WHERE studentName = '$selectedStudentName' LIMIT 1";
    $result0 = $mysqli->query($query0);
    $row = $result0->fetch_assoc();
    $selectedStudentId = $row['studentId'];

    $queryA = "SELECT testId FROM tests WHERE testName = '$selectedTestName' LIMIT 1";
    $resultA = $mysqli->query($queryA);
    $row = $resultA->fetch_assoc();
    $selectedTestId = $row['testId'];


} else {
    // Handle error if parameters are not set
    echo "Error: Test name or student ID not provided.";
    exit;
}

// Check if the form is submitted
if(isset($_POST['submitFeedback'])) {
    // Process the submitted feedback
    if(isset($_POST['pointsAwarded']) && isset($_POST['feedback'])) {
        $pointsAwarded = $_POST['pointsAwarded'];
        $feedback = $_POST['feedback'];
        $studentIds = $_POST['studentId'];
        $questionIds = $_POST['questionId'];
        $totalPointsAwarded = array_sum($pointsAwarded);
        $testGradePercent = (($totalPointsAwarded / 10) * 100);


        $query = "UPDATE studenttests 
                      SET grade = '$testGradePercent'
                      WHERE studentId = '$selectedStudentId' AND testId = '$selectedTestId'";
        $mysqli->query($query);

        for($i = 0; $i < count($pointsAwarded); $i++) {
            $studentId = $studentIds[$i];
            $questionId = $questionIds[$i];
            $points = $pointsAwarded[$i];
            $feedbackText = $feedback[$i];

            $query = "UPDATE studentanswers 
                      SET pointsAwarded = '$points', feedback = '$feedbackText'
                      WHERE studentId = ' $selectedStudentId' AND questionId = '$questionId'";
            $mysqli->query($query);


        }

    }

    ?>
<script>
    $(document).ready(function(){
        alert("Assessment has been submitted.");
    });
    </script>

<?php } ?>

<!doctype html>
<html>
<head>
    <title>Grade Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="tests.css">
</head>
<body>
<div id="containerGradeTest">
    <?php require_once('../indexMain/navTeacher.php'); ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?testName=' . urlencode($selectedTestName) . '&studentName=' . urlencode($selectedStudentName); ?>">

            <input type="hidden" name="studentId" value="<?php echo $selectedStudentId; ?>">


        <?php
        $query1 = "SELECT * FROM questions WHERE testId = " .$selectedTestId ;
        $result1 = $mysqli->query($query1);
        $questions = $result1->fetch_all(MYSQLI_ASSOC);

        $totalPoints =0;

        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th  >Question</th><th>Correct Answer</th><th>Student Answer</th><th>Points</th><th>Points Awarded</th><th>Feedback</th></tr></thead>";
        echo "<tbody>";

        foreach ($questions as $question) {

            $totalPoints += $question['points'];

            echo "<tr>";
            echo "<td>" . $question['questionText'] . "</td>";

            $questionId = $question['questionId'];

            $query2 = "SELECT * FROM answers WHERE questionId = " . $questionId;
            $result2 = $mysqli->query($query2);
            $answers = $result2->fetch_all(MYSQLI_ASSOC);

            foreach ($answers as $answer) {
                echo "<td>" . $answer['answerText'] . "</td>";
            }

            $query3 = "SELECT * FROM studentanswers WHERE questionId = " . $questionId . " AND studentId = " . $selectedStudentId;
            $result3 = $mysqli->query($query3);
            $studentanswers = $result3->fetch_all(MYSQLI_ASSOC);
            foreach ($studentanswers as $studentanswer) {
                echo "<td>" . $studentanswer['studentAnswer'] . "</td>";
            }
            echo "<td>" . $question['points'] . "</td>";
            echo "<input type='hidden' name='studentId[]' value='$selectedStudentId'>";
            echo "<input type='hidden' name='questionId[]' value='$questionId'>";
            echo "<td><input type='text' class='pointsAwarded' name='pointsAwarded[]'></td>";
            echo "<td><input type='text' name='feedback[]'></td>";
            echo "</tr>";
        }
         ?> <input type="hidden" name="totalPoints" value="<?php echo $totalPoints; ?>">
            <?php
        echo "</table>";


        $totalPointsAwarded = 0;

//          for ($i = 0; $i < count($pointsAwarded); $i++) {
//            $points = $pointsAwarded[$i];
//            $totalPointsAwarded += $points;
//        }


            echo "<table id='small-table' class='table table-bordered'>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td>Student Score</td>";
            echo "<td id='totalPointsAwarded' >  $totalPointsAwarded    </td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Total</td>";
            echo "<td id='totalPoints' >$totalPoints</td>";
            echo "</tr>";
        echo "<tr>";
        echo "<td>Percent</td>";
        echo "<td id='testGradePercent' >$testGradePercent%</td>";
        echo "</tr>";

        echo "</tbody></table>";
        echo "<br>";

        $result1->free();
        $result2->free();
        $result3->free();
        $result0->free();
            ?>
        <input type="submit" name="submitFeedback" value="Submit Feedback">
    </form>
    <script>
        $(document).ready(function(){
            $('.pointsAwarded').on('input', function() {
                var totalPointsAwarded = 0;
                $('.pointsAwarded').each(function() {
                    var points = parseFloat($(this).val()) || 0;
                    totalPointsAwarded += points;
                });
                $('#totalPointsAwarded').text(totalPointsAwarded.toFixed(1));

                var totalPoints = parseFloat($('#totalPoints').text());
                var testGradePercent = (totalPointsAwarded / totalPoints) * 100;
                $('#testGradePercent').text(testGradePercent.toFixed(1) + "%");
            });
        });
    </script>


</div>
</body>
</html>
