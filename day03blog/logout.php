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
<?php
    // session_reset ():
    unset($_SESSION['blogUser']);
?>
<p>You've been logged out. <a href=ïndex.php:>Click to continue</a></p>
</body>
</html>