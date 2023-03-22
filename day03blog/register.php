<?php // Establishing connection to the database
    require_once 'db.php'; ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Registration</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name=username]').keyup(function(){
                var username= $(this).val();// same as: var username =$('input[name=username'].val();
                console.log('username:' + username);
                $('#usernameTaken').load("isusenametaken.php?username=" + username)
            });
            //$('#usernameTaken')
        });
    </script>
</head>

<body>
    <div id="centeredContent">
    <?php

    function printForm($username = "", $email = "") {
        $form = <<< END
        <form>
        Username: <input name-"username" type- "text" value- "$username"> 
        <span id-"usernameTaken" class-"errorMessage"></span><br>
        Email: <input name-"email" type-"email" value-"$email">br>
        Password: <input name="pass1" type-"password"><br»
        Password (repeated): <input name-"pass2" type= "password"><br>
        <input type-"submit" value-"Register">
        </form>
        END;
        echo $form;
    }

    if (isset ($_POST ["username"])) {
        $username = $_POST ['username'];
        $email = $_POST[' email'];
        $pass1 = $_POST[ 'pass1'];
        $pass2 = $_POST[ 'pass2'];
        $errorList = [];
    }
            // name must be 2-20 characters long
            if (preg_match('/^[a-z][a-z0-9_]{3,19}$/', $username) !== 1) {
                $errorList[] = "Username must be made up of 4-20 letters, digits, or underscore. The first character must be a letter";
                $username = "";
            } else {
                // validate that this username is not already registered
                $result = mysqli_query($link, sprintf("SELECT id FROM users WHERE username='%s'",
                    mysqli_real_escape_string($link, $username)));

                if (!$result) {
                    die("SQL Query failed: ". mysqli_error ($link));
                }
                $userRecord = mysqli_fetch_assoc($result);
                if ($userRecord) {
                    $errorList[]="This username is already registered";
                    $username = "";
                } else {
                    echo "Username available";
            }
        }
         
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errorList[] = "Email does not look valid";
                $email = "";
            }
            if ($pass1 != $pass2) {
                $errorList[] = "Passwords do not match";
            } else {
                if ( 
                    strlen($pass1) < 6 || strlen($pass1) > 100
                    || (preg_match("/[A-Z]/", $pass1) !== 1)
                    || (preg_match("/[a-z]/", $pass1) !== 1)
                    || (preg_match("/[0-9]/", $pass1) !== 1)
                ){
                    $errorList[] = "Password must be 6-100 characters long and contain at least one"
                        . "uppercase letter, one lowercase, and one digit.";
                }
            }
            //
            if($errorList) { // STATE 2: submission with errors
                echo '<ul class="errorMessage">' . "\n";
                foreach ($errorList as $error) {
                    echo "<li>$error</li>\n";
                }
                echo "</ul>\n";
                printForm($username, $email);
            } else { // STATE 3: success
                // TODO: insert record to register a new user
                $sq1 = sprintf(
                    "INSERT INTO users VALUES (NULL, '%s', '%s', '%s')",
                    mysqli_real_escape_string($link, $username),
                    mysqli_real_escape_string($link, $email), 
                    mysqli_real_escape_string($link, $pass1)
                );
                if (!mysqli_query($link, $sq1)) {
                    die("Fatal error: failed to execute SQL query: " . mysqli_error($link));
                }
                echo "<p>Registration successful</p>";
                echo '<p><a href="index.php"> Click to continue </a></p>';
            }

            printForm();
    
    ?>
    </div>
</body>
</html>