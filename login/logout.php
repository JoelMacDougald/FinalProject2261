<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

//Start the session
session_start();
// check for logged in session
if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'])
{

    header("Location: ../mainPage.php");
    exit;
}else{
    //Set username from $_SESSION associative array
    $userName = $_SESSION["username"];

    // Remove all of the session variables.
    session_unset();

// Delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

// Destroy the session

    if(session_destroy())
    {
        header("Location: ../indexMain/mainPage.php?message=logout&userName=".$userName);
        exit;
    }

}





