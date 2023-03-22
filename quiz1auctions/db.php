<?php

$dbName = 'quiz1auctions';
$dbUser = 'quiz1auctions';
$dbPass = 'wODP9@_HvP';
// $dbUser = 'root';
// $dbPass = 'admin';
$dbHost = 'localhost'; //127.0.0.1

$link = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_errno()) {
    die("Fatal error: failed to connect to MySQL - " . mysqli_connect_error());
}

?>

