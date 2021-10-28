<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="../css/normalize.css">
    <link rel="stylesheet" href="./css/administration.css">
    <title>Cantina - Admin</title>
    <?php
    include '../header.php';
    ?>
    <?php
        if(isset($_POST['senderJson']))
        {
            file_put_contents("../products.json", json_encode(json_decode($_POST['senderJson']), JSON_PRETTY_PRINT));
        }
    ?>
</head>
<body>
    <div class="general-background">
        <div class="button">
            <input type="button" id="product-admin" value="Administrar Productes">
        </div>
        <div class="button">
            <input type="button" id="product-manage" value="Agregar Productes">
        </div>
        <div class="button">
            <input type="button" id="ticket-admin" value="Mostrar Tickets">
        </div>
    </div>
    
    <?php 
    include '../footer.php';
    ?>
</body>
</html>