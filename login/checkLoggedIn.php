<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

//ensuring user is logged in
if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'])
{

    header("Location: loginStudent.php?message=notLoggedIn");
    exit;
}