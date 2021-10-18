<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Confirmat!</title>
    <?php
        
        $username = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $productList = array("producto" => "Coca-Cola", "producto2" => "BeiconQueso"); //poner el array con los productos escogidos en pickup.php

        $ticket = array("username" => $username, "email" => $email, "phone" => $phone, "products" => $productList);

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $arrayTicket = json_decode(file_get_contents("tickets.json"), true);
            array_push($arrayTicket, $ticket);
            file_put_contents("tickets.json", json_encode($arrayTicket, JSON_PRETTY_PRINT));
        }
    ?>
</head>
<body>
    <h1>CHECKOUT PAGE (WIP)</h1>
    <p>La teva comanda ha estat realitzada correctament.</p>
    <a href="./index.html">
        <input type="button" value="Tornar al menú inicial">
    </a>
</body>
</html>