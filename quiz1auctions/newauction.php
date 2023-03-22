<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>New Auction</title>
</head>
<body>
    <?php
        require_once('db.php');

        function printForm($sellerName = "", $sellerEmail = "", $lastBidPrice = "", $itemDescription = "", $itemImagePath = "") {
            $form = <<< END
            <form method="POST">

            <label for="seller-name">Seller Name:</label><br>
            <input type="text" id="seller-name" name="sellerName" value="{$sellerName}" minlength="2" maxlength="100" required><br>
            
            <label for="seller-email">Seller Email:</label><br>
            <input type="email" id="seller-email" name="sellerEmail" value="{$sellerEmail}" required><br>

            <label for="item-description">Item Description:</label><br>
            <textarea id="item-description" name="itemDescription" minlength="2" maxlength="1000">{$itemDescription}</textarea><br>

            <label for="initial-bid-price">Initial Bid Price:</label><br>
            <input type="number" id="initial-bid-price" name="lastBidPrice" value="{$lastBidPrice}" min="0" step="0.01" required><br>
            
            <label for="item-image">Item Image:</label><br>
            <input type="file" id="item-image" name="itemImagePath" accept="image/jpeg,image/gif,image/png,image/bmp" required><br>

            <input type="submit" value="Place Bid">
            </form>
            END;
            echo $form;
        }

        if (isset ($_POST ["sellerName"])) {
            $sellerName = $_POST['sellerName'];
            $sellerEmail = $_POST['sellerEmail'];
            $itemDescription = $_POST['itemDescription'];
            $lastBidPrice = $_POST['lastBidPrice'];

            $errorList = [];

            if (preg_match('/^[a-zA-Z0-9\s.,-]{2,100}$/', $sellerName) !== 1) {
                $errorList[] = "Seller's name must be made up of 2-100 letter or digits";
                $sellerName = "";
            }
            
            if (!filter_var($sellerEmail, FILTER_VALIDATE_EMAIL)) {
                $errorList[] = "Invalid email format";
                $sellerEmail = "";
            }
    
            if (empty($lastBidPrice)) {
                $errorList[] = "Initial bid price is required";
            } else {
                $lastBidPrice = floatval($lastBidPrice);
                if ($lastBidPrice <= 0) {
                    $errorList[] = "Initial bid price must be greater than zero";
                }
            }
            
            if ($errorList) {
                echo '<ul class="errorMessage">' . "\n";
                    foreach ($errorList as $error) {
                        echo "<li>$error</li>\n";
                    }
                echo "</ul>\n";
                    printForm($sellerName, $sellerEmail, $lastBidPrice, $itemDescription, $itemImagePath);
                
            } else {
                $sql = sprintf(
                    "INSERT INTO auctions (sellerName, sellerEmail, lastBidPrice, itemDescription, itemImagePath) 
                    VALUES ('%s', '%s', '%s', '%s', '%s')",
                    mysqli_real_escape_string($link, $sellerName),
                    mysqli_real_escape_string($link, $sellerEmail),
                    mysqli_real_escape_string($link, $lastBidPrice),
                    mysqli_real_escape_string($link, $itemDescription),
                    mysqli_real_escape_string($link, $itemImagePath)
                    );
    
                if (!mysqli_query($link, $sql)) {
                    die("Fatal error: failed to execute SQL query: " . mysqli_error($link));
                }
                
                else { 
                    echo "<p>Item uploaded successfully</p>";
                }
            }
        } else {
            printForm();
        }
    ?>

</body>
</html>