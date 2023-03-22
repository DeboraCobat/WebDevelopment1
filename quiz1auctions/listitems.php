<?php // Establishing connection to the database
    require_once ('db.php'); ?>
    
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
    $sql = "SELECT itemDescription, itemImagePath, sellerName, lastBidPrice, id FROM auctions";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Item Description</th><th>Image</th><th>Seller's Name</th><th>Last Bid Price</th><th>Make a Bid</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["itemDescription"]."</td>";
            echo "<td><img src='".$row["itemImagePath"]."' width='150'></td>";
            echo "<td>".$row["sellerName"]."</td>";
            echo "<td>".$row["lastBidPrice"]."</td>";
            echo "<td><a href='placebid.php?id=".$row["id"]."'>Make a Bid</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No auctions found.";
    }

    mysqli_close($link);
?>

</body>
</html>