<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(document).ready(function() {
        $("#submit_bid").click(function() {
            var id = $("#auction_id").val();
            var bid = $("#bid_value").val();
            
            $.ajax({
            url: "submit_bid.php",
            type: "POST",
            data: {id: id, bid: bid},
            success: function(response) {
                if (response === "") {
                // new bid is higher, do nothing
                } else {
                // new bid is too low
                alert(response);
                }
            }
            });
        });
        });
    </script>
    <title>Is bid to low</title>
</head>
<body>
    
</body>
</html>