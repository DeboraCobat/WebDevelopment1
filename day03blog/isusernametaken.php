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
      if (!isset($_GET['username'])){
         die ("Error: username parameter not provide");

      }
      $username = $_GET['username'];
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

      }
      ?>
      </body>
      </html>
