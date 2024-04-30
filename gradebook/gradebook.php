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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gradebook</title>
</head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="gradebook.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<body>
<div id="containerGradebook">
    <?php
    require_once('../indexMain/navStudent.php');


    $reportSelected = "Section Report";
    $sectionSelected = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $sectionSelected = $_POST['sectionSelected'];
        $reportSelected = $_POST['reportSelected'];
        $testSelected = $_POST['testSelected'];

        $_SESSION['sectionId'] = $sectionSelected;
        $_SESSION['testSelected'] = $testSelected;


        // Redirect to the next page with the captured values
        if ($reportSelected == "Test Report") {
            header("Location: testReport.php?sectionId=" . urlencode($sectionSelected));
            exit;
        }

        if ($reportSelected == "Section Report") {
            header("Location: sectionReport.php?sectionId=" . urlencode($sectionSelected));
            exit;
        }
    }
    ?>
    <h1>Welcome to the gradebook page.</h1>
    <br>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php
        require_once('../login/lib/config.php');

        echo "<h2>Choose the Section</h2>";
        $query = "SELECT * FROM section";
        $result = $mysqli->query($query);

        echo '<select name="sectionSelected">';
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["sectionId"] . '">' . $row["sectionId"] . '</option>';
            }
        } else {
            echo '<option value="">No sections found</option>';
        }
        echo '</select>';
        echo "<br>";
        echo "<h2>Choose the Report</h2>";
        echo '<select id="reportSelected" name="reportSelected">';
        echo '<option value="Section Report">Section Report</option>';
        echo '<option value="Test Report">Test Report</option>';

        echo '</select>';

        echo "<div id='testDropdown' style='display: none;'>";
        echo "<h2>Choose the Test</h2>";
        echo '<select name="testSelected">';

        $query1 = "SELECT * FROM tests";
        $result1 = $mysqli->query($query1);
        $tests = $result1->fetch_all(MYSQLI_ASSOC);
        foreach ($tests as $test) {
            echo "<option value='{$test['testName']}'>{$test['testName']}</option>";
        }
        echo '</select>';
        echo "</div>";

        echo "<br>";
        echo "<br>";
        echo '<input type="submit" name="submit" value="Submit">';
        ?>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#reportSelected').change(function () {
            var selectedReport = $(this).val();
            if (selectedReport === "Test Report") {
                $('#testDropdown').show();
            } else {
                $('#testDropdown').hide();
            }
        });
    });
</script>

</body>
</html>
