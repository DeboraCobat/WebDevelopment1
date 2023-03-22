<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passport upload</title>
</head>

<body>
    <?php
    require_once 'db.php';

    function printForm($passportNo = "")
    {
        $passportNo = htmlentities($passportNo); // avoid invalid html in case <>" are part of name
        $form = <<< END
            <form method="post" enctype="multipart/form-data">
                Passport No.: <input type="text" name="passportNo" value="$passportNo"><br>
                Photo: <input type="file" name="photo" /><br>
                <input type="submit" name="submit" value="Add passport">
            </form>
        END;
        echo $form;
    }

    // returns TRUE on success
    // returns a string with error message on failure
    // on success $newFilePath is assigned file name after upload
    function verifyUploadedPhoto(&$newFilePath, $passportNo)
    {
        // echo "<pre>\n\$_FILES content:\n";
        // print_r($_FILES);
        // echo "</pre>\n";
        $photo = $_FILES['photo'];
        // is there a photo being uploaded and is it okay?
        if ($photo['error'] != UPLOAD_ERR_OK) {
            return "Error uploading photo " . $photo['error'];
        }
        if ($photo['size'] > 2 * 1024 * 1024) { // 2MB
            return "File too big. 2MB max is allowed.";
        }
        $info = getimagesize($photo['tmp_name']);
        // echo "<pre>\ngetimagesize result:\n";
        // print_r($info);
        // echo "</pre>\n";
        if ($info[0] < 100 || $info[0] > 1000 || $info[1] < 100 || $info[1] > 1000) {
            return "Width and height must be within 200-1000 pixels range";
        }
        $ext = "";
        switch ($info['mime']) {
            case 'image/jpeg':
                $ext = "jpg";
                break;
            case 'image/gif':
                $ext = "gif";
                break;
            case 'image/png':
                $ext = "png";
                break;
            default:
                return "Only JPG, GIF, and PNG file types are accepted";
        }
        // Other solutions to generate file name:
        // UUID or other random name using uniqid();
        // sanitize the uploaded filename and make sure it's unique
        // $partialName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $photo['name']);
        // then you need a loop to make sure the filename doesn't exist yet, append an incremented number
        $newFilePath = "uploads/" . $passportNo . "." . $ext;
        return TRUE;
    }

    // submision or first show?
    if (isset($_POST['submit'])) {
        $passportNo = $_POST['passportNo'];
        $errorList = array();
        if (preg_match('/^[A-Z]{2}[0-9]{6}$/', $passportNo) != 1) {
            $errorList[] = "Passport number must be in AB123456 format";
        }
        // make sure passport number does not already exist in the database
        $result = mysqli_query($link, sprintf(
            "SELECT * FROM passports where passportNo='%s'",
            mysqli_real_escape_string($link, $passportNo)
        ));
        if (!$result) {
            die("SQL Query failed: " . mysqli_error($link));
        }
        $existingPassport = mysqli_fetch_assoc($result);
        if ($existingPassport) {
            $errorList[] = "Passport $passportNo already exists in the database";
            $passportNo = "";
        }
        $photoFilePath = null;
        $retval = verifyUploadedPhoto($photoFilePath, $passportNo);
        if ($retval !== TRUE) {
            $errorList []= $retval; // string with error was returned, add it to error list
        }
        // TODO: verify upload
        if ($errorList) { // STATE 2: errors in submission - failed
            echo "<p>There were problems with your submission:</p>\n<ul>\n";
            foreach ($errorList as $error) {
                echo "<li class=\"errorMessage\">$error</li>\n";
            }
            echo "</ul>\n";
            printForm($passportNo);
        } else { // STATE 3: successful submission
            // 1. move uploaded file to its desired location
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoFilePath)) {
                die("Error moving the uploaded file. Action aborted.");
            }
            // 2. insert a new record with file path
            $sql = sprintf("INSERT INTO passports VALUES (NULL, '%s', '%s')",
                mysqli_real_escape_string($link, $passportNo),
                mysqli_real_escape_string($link, $photoFilePath));
            $result = mysqli_query($link, $sql);
            if (!$result) {
                die("SQL Query failed: " . mysqli_error($link));
            }
            // 3. display confirmation to the user
            echo "<p>Passport successfully added</p>";
        }
    } else { // STATE 1: first show
        printForm();
    }
    ?>
</body>

<!-- HOMEWORK - file upload
========

In database 'day01first' add a new table 'passports' with the following structure:

- id INT PK AI
- passportNo VC(20) UNIQ
- photoFilePath VC(200) UNIQ NULL

Create addpassport.php file which will handle 3-state form that allows user to submit their passport number and select a photo to upload.

Field passportNo must be composed of two uppercase letters followed by 6 digits exactly.

Photos uploaded must be:
- one of these formats: jpg, gif, png
- their width and height must be within 200-1000 pixels range
- size not larger than 2MB

Create subdirectory 'uploads/' in your 'day01first' directory. This is where you will upload your files when they are submitted via the form.

The file names will be constructed of passportNo and the extension will match the file type uploaded. E.g. AB12345678.jpg

Other options to consider: use UUID generator for the file, or sanitaze the file name of the upload, and make sure it's unique.

Once you have above implemented create viewallpassports.php file which will display a table with id, passportNo and the image columns showing all data of passports table.
You can set width of img tag to 150 pixels.

MODIFICATION to try later:

Allow photo to be optional. Assign value NULL to photoFilePath if file is not provided.
 -->

</html>





