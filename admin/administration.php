<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Admin</title>
    <?php
    include 'header.php';
    ?>
    <?php
    if(isset($_POST['senderJson']))
    {
        file_put_contents("../products.json", json_encode(json_decode($_POST['senderJson']), JSON_PRETTY_PRINT));
    }
    
    ?>
</head>
<body>
    <h1>ADMINISTRATION PAGE (WIP)</h1>
    
    <?php 
    include 'footer.php';
    ?>
</body>
</html>