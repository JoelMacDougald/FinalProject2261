<?php
// Author: Joel MacDougald
// Due Date: February 10th, 2024
// Purpose: CIS2261 Final Project

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'school');

/* Attempt to connect to MySQL database
the username and password to login are siteAdminAccount     CISpass*/
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
