<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do form</title>
</head>
<body>

    <?php

    require_once('db.php');

    function printForm($taskVal = "", $difficultyVal = "Easy", $isDoneVal = false) {
        $diffArray = array("Easy" => "", "Medium" => "", "Hard" => "");
        $diffArray[$difficultyVal] = 'checked';
        $isDoneChecked = $isDoneVal ? "checked" : "";
        $form = <<< END
        <form method="post">
        <label for="task">Task:</label> <input type="text" name="task" value="$taskVal"><br>
        <label for="difficulty">Difficulty:</label>
        <input type="radio" name="difficulty" value="Easy" {$diffArray['Easy']}>Easy
        <input type="radio" name="difficulty" value="Medium" {$diffArray['Medium']}>Medium
        <input type="radio" name="difficulty" value="Hard" {$diffArray['Hard']}>Hard
        <br>
        <label for="isDone">Is done?</label>
        <input type="checkbox" name="isDone" value="1" $isDoneChecked>
        <br>
        <input type="submit" value="Create task">
        </form>
        END;
        echo $form;
    }

    if (isset($_POST["task"])) {
            /* // variable printout for debugging purposes - example
            echo "<pre>\n";
            echo '$_POST:' . "\n";
            print_r($_POST);
            // var_dump($_GET);
            echo "</pre>\n"; */

            $task = $_POST['task'];
            $difficulty = $_POST['difficulty'];
            $isDone = isset($_POST['isDone']);
            
            $errorList = [];
            // name must be 2-20 characters long
            if (strlen($task) < 2 || strlen($task) > 50) {
                $errorList []= "Task must be 2-50 characters long"; // append to array
                $task = "";
            }
            // TODO: make sure difficulty is one of the values expected
            if (!in_array($difficulty,['Easy','Medium','Hard'])) {
                $errorList []= "Difficulty value invalid (possibly internal error)"; // append to array
            }
            //
            // (count($errorList)) {// (count($errorList) > 0) {
            if ($errorList) { // STATE 3: display errors and the form again
                echo "<p>Submission failed, errors found:</p>\n";
                echo "<ul>\n";
                foreach ($errorList as $error) {
                    echo "<li>$error</li>\n";
                }
                echo "</ul>\n";
                printForm($task, $difficulty, $isDone);
            } else { // STATE 2: successful submission
                $sql = sprintf("INSERT INTO todos VALUES (NULL, '%s', '%s', '%s')",
                    mysqli_real_escape_string($link, $task),
                    mysqli_real_escape_string($link, $difficulty),
                    $isDone ? 1 : 0
                );
                if (!mysqli_query($link, $sql)) {
                    die("Fatal error: failed to execute SQL query: " . mysqli_error($link));
                }
                echo "<p>Task added</p>";
            }
        } else { // STATE 1: first display
            printForm();
        }

    ?>

</body>

<!-- HOMEWORK
========

TodoForm
---------

In directory 'day01first' create file "4todoform.php" (all lower-case).

Using an HTML form ask the user for task (text input), difficulty (radio buttons), and whether it's done or not (checkbox), similar to:

Task:        [_____________________]
Difficulty:  ( ) Easy     (*) Medium hard         ( ) Hard
Is done?     [ ] Done
      [[ Create task ]]

When the form is submitted display the following information, example:

This is a Medium hard task "Go get milk" and is not done.

Implement the form to submit using POST method.

Later 1: add validation to require that the task description is between 2-50 characters long.
If it is not then display an error message and redisplay the form, with other choices preserved.

Later 2: in day01 database declare table 'todos':
- id INT PK AI
- task VC(50)
- difficulty ENUM('Easy','Medium','Hard')
- isDone TINYINT (0 when pending, 1 when done)

Implement INSERT to this table when the form is submitted successfully.


No CSS is required at this time.

Contain the entire solution in a single PHP file. -->

</html>

