<?php

session_start();

$dbName = 'day03blog';
$dbUser = 'day03blog';
$dbPass = 'VN8PQAhb';
// $dbUser = 'root';
// $dbPass = 'admin';
$dbHost = 'localhost'; // 127.0.0.1

$link = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_errno()) {
    die("Fatal error: failed to connect to MySQL - " . mysqli_connect_error());
}

?>