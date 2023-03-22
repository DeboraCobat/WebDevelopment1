<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Database!</title>
</head>
<body>
    
<?php

require_once('db.php');

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    $age = random_int(1,100);
    // TODO: talk about SQL Injection
    $sql = sprintf("INSERT INTO friends VALUES (NULL, '%s', '%s')",
            mysqli_real_escape_string($link, $name),
            mysqli_real_escape_string($link, $age));
    if (!mysqli_query($link, $sql)) {
        die("Fatal error: failed to execute SQL query: " . mysqli_error($link));
    }
    echo "<p>Hello " . $name . "! (from PHP)</p>";
} else {
    echo "<p>Please provide name=... parameter in the URL</p>";
}
?>

</body>
</html> 