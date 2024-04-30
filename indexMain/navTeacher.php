<!--// Author: Joel MacDougald-->
<!--// Due Date: February 10th, 2024-->
<!--// Purpose: CIS2261 Final Project-->


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../indexMain/indexTeacher.php">CEOS</a>

        </div>
        <div class="navbar-header navbar-right">
            <?php if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                ?>
                <a class="navbar-brand" href="#">Welcome <?php echo $_SESSION["teacherName"]; ?></a>
                <a class="navbar-brand" href="../login/logout.php">Logout</a>
            <?php } else { ?>
                <a class="navbar-brand" href="#">Welcome Guest</a>
                <a class="navbar-brand" href="../login/loginStudent.php">Please Login</a>
            <?php } ?>
        </div>
    </div>
</nav>