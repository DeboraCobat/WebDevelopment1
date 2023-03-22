<?php // Establishing connection to the database
    require_once 'db.php'; ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="centeredContent">
    <?php
    //is someone logged in?
    if (isset ($_SESSION['blogUser'])) {
        echo "<p> You are logged in as " . $_SESSION['blogUser']['username'] . " . ";
        echo 'You can <a href-"logout.php">logout</a> or <a href-"addarticle.php">post an article</a></p>' . "\n";
    } else {
        echo '<p><a href-"logih.php">login</a> or <a href-"register.php">register</a> to post articles and comments. </p>'. "\n";
    }
    ?>
    </div>
</body>
</html>