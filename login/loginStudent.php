<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

//Start the session
session_start();


if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {

    header("location:../indexMain/indexStudent.php");
    exit;
}
if (!isset($_POST['submit'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Student</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="login.css">
        <script>

            function error() {

                document.getElementById("error").style.display = "inline";

            }
        </script>
    </head>
    <body>
    <div class="login-form">
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <h2 class="text-center">Log in</h2>
            <?php if (isset($_GET["message"])) {

                if ($_GET["message"] == "loginError") {

                    echo '<p id="error" style="color: red;">Invalid Login</p>';

                } else if ($_GET["message"] == "logout") {

                    echo '<p id="error" style="color: blue;">Goodbye ' . $_GET["userName"] . '</p>';

                } else if ($_GET["message"] == "notLoggedIn") {

                    echo '<p id="error" style="color: blue;">You must login</p>';

                }
            }
            ?>
            <div class="form-group">
                <input type="text" name="studentId" class="form-control" placeholder="StudentId" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Log in</button>
            </div>

        </form>

    </div>
    </body>
    </html>
    <?php
} else {
    include("lib/config.php");

    $studentId = $mysqli->real_escape_string($_POST['studentId']);
    $password = $mysqli->real_escape_string($_POST['password']);


    // SHA1() calculates a SHA-1 160-bit checksum for the string
    //One of the possible uses for this function is as a hash key.
    //source - https://dev.mysql.com/doc/refman/8.0/en/encryption-functions.html#function_sha1

    $query = "SELECT * FROM student WHERE BINARY studentId='" . $studentId . "' AND pass=sha1('" . $password . "')";

    $result = $mysqli->query($query);
    //echo "query: ".$query."<br/>Num Rows: ".$result->num_rows;

    if ($result = $mysqli->query($query)) {
        // If result matched $username and $password, table row must be 1 row

        if ($result->num_rows == 1) {

            // Register $username, $password and redirect to file "indexStudent.php"
            $_SESSION["studentId"] = $studentId;
            $row = $result->fetch_assoc();
            $studentName = $row['studentName'];
            $_SESSION['studentName'] = $studentName;
            //$_SESSION["password"] = $password;

            // set a session variable that is checked for
            // at the beginning of any of your secure .php pages
            $_SESSION["loggedIn"] = true;

            header("location:../indexMain/indexStudent.php");
        } else {
            //echo "<script type='text/javascript'>alert('User Name Or Password Invalid!')</script>";
            //echo '<script type="text/javascript">error();</script>';
            $location = $_SERVER['PHP_SELF'] . "?message=loginError";
            header("Location:" . $location);
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
    }

}


