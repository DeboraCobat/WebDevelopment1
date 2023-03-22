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

    function printForm($username = "", $email = "") {
        $form = <<< END
        <form>
        Username: <input name="username" type="text" value="$username"> 
        <span id="usernameTaken" class="errorMessage"></span><br>
        Email: <input name="email" type="email" value="$email"><br>
        Password: <input name="pass1" type="password"><br>
        Password(repeated): <input name-"pass2" type= "password"><br>
        <input type="submit" value="Register">
        </form>
        END;
        echo $form;
    }

    if (isset ($_POST ["username"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //
        $result = mysqli_query($link, sprintf("SELECT * FROM users WHERE username='%s'",
        mysqli_real_escape_string($link, $username)));

        if (!$result) {
        die("SQL Query failed: ". mysqli_error ($link));
        }
    
        $userRecord = mysqli_fetch_assoc($result);
        $loginSuccessful = ($userRecord != null) && ($userRecord['password'] == $password);

        //
        if (!$loginSuccessful) { // STATE 2: login failed
            echo '<p class="errorMessage">Invalid username or password</p>'; 
            printForm();
        } else { // STATE 3: login successful
            unset($userRecord['password']); // for safety reasons remove the password
            $_SESSION['blogUser'] = $userRecord;
            echo "<p>login successful</p>";
            echo '<p><a href-"index.php">Click here to continue</a></p>';
        }
    } else {
        printForm();
    }
    ?>
</body>
</html>