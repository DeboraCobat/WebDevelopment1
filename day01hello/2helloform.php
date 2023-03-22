<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello form!</title>
</head>
<body>

    <?php

    function printForm($nameVal = "", $ageVal = "") {
        $form = <<< END
        <form>
        Name: <input type="text" name="name" value="$nameVal"><br>
        Age: <input type="number" name="age" value="$ageVal"><br>
        <input type="submit" value="Say hello">
        </form>
        END;
        echo $form;
    }

        if (isset($_GET["name"])) {
            /* // variable printout for debugging purposes - example
            echo "<pre>\n";
            echo '$_GET:' . "\n";
            print_r($_GET);
            var_dump($_GET);
            echo "</pre>\n"; */

            $name = $_GET["name"];
            $age = $_GET['age'];
            $errorList = [];
            // name must be 2-20 characters long
            if (strlen($name) < 2 || strlen($name) > 20) {
                // equivalent to: array_push($errorList, "Name must be 2-20 characters long");
                $errorList []= "Name must be 2-20 characters long"; // append to array
                $name = "";
            }
            // age must be a integer, 1-150 value
            if (!is_numeric($age) || $age < 1 || $age > 150) {
                $errorList []= "Age must be 1-150"; // append to array, same as array_push()
                $age = "";
            }
            //
            if ($errorList) { // (count($errorList)) {// (count($errorList) > 0) {
                echo "<p>Submission failed, errors found:</p>\n";
                echo "<ul>\n";
                foreach ($errorList as $error) {
                    echo "<li>$error</li>\n";
                }
                echo "</ul>\n";
                printForm($name, $age);
            } else {
                echo "<p>Hi $name, you are $age y/o. Nice to meet you.</p>";
            }
        } else {
            printForm();
        }

    ?>

</body>
</html>