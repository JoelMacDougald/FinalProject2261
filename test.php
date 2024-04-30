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
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
<div id="container">
    <?php require_once('../indexMain/navTeacher.php'); ?>

    <div class="text-center">
        <a href="testClass1.php" class="btn btn-primary">Class 1</a>
        <a href="testClass1.php" class="btn btn-secondary">Class 2</a>
        <a href="testClass1.php" class="btn btn-primary">Class 3</a>

    </div>


    <h1>Choose the test to grade.</h1>
    <br>
    <form id="chooseForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php
        require_once('../login/lib/config.php');

        echo "<h2>Choose the Class</h2>";
        $query = "SELECT * FROM classes";
        $result = $mysqli->query($query);

        echo '<select name="classSelected">';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["classId"] . '">' . $row["classId"] . '</option>';
            }
        } else {
            echo '<option value="">No sections found</option>';
        }
        echo '</select>';

        echo "<br>";

        echo "<div id='testDropdown' style='display: none;'>";
        echo "<h2>Choose the Test</h2>";
        $classSelected = $_POST['classSelected'];
        $query = "SELECT * FROM test WHERE classId = '$classSelected'";
        $result = $mysqli->query($query);

        echo '<select name="testSelected">';
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["testId"] . '">' . $row["testId"] . '</option>';
            }
        } else {
            echo '<option value="">No tests found</option>';
        }
        echo '</select>';
        echo "</div>";

        echo "<br>";

        echo "<div id='studentDropdown' style='display: none;'>";
        echo "<h2>Choose the Student</h2>";
        $query = "SELECT * FROM student WHERE classId = '$classSelected'";
        $result = $mysqli->query($query);

        echo '<select name="studentSelected">';
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["studentName"] . '">' . $row["studentName"] . '</option>';
            }
        } else {
            echo '<option value="">No students found</option>';
        }
        echo '</select>';
        echo "</div>";



        echo '<input type="submit" name="submit" value="Submit">';
        ?>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#classSelected').change(function(){
            var selectedClass = $(this).val();
            if(selectedClass !== '') {
                $('#testDropdown').show();
            } else {
                $('#testDropdown').hide();
            }
        });
    });
</script>
</body>
</html>
