<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        header('Location: http://localhost/error.php');
    }
    if(isset($_POST["basket"])
    {
        $ticketObjects = json_decode($_POST["basket"]);
        $_SESSION["ticketObjects"] = $ticketObjects;
    }
    else if(isset($_SESSION["ticketObjects"] )
    {
        $ticketObjects = json_decode($_SESSION["ticketObjects"]);
    }
    else
    {
        header('Location: http://localhost/error.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/confirmation.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Cantina - Confirmació</title>
    <?php
        $jsonProducts = json_decode(file_get_contents("products.json"));

        $HTML_ticket = LoadTicket($jsonProducts, $ticketObjects);
        function LoadTicket($jsonProducts, $ticketObjects)
        {
            $str = "";
            for ($x=0; $x < count($ticketObjects) ; $x++) { 
                $productObj = $ticketObjects[$x];
                $key= array_search($productObj->productId, array_column($jsonProducts, 'id'));
                $str .= "<div class='product-in-ticket'>".
                "<div>".($jsonProducts[$key]->productName)."</div>".
                "<div>quantity:".($productObj->quantity)."</div>".
                "<div>Price: ".( (floatval($jsonProducts[$key]->price) ) *$productObj->quantity)."€</div></div>";
            }
            return $str;
        }

        
    ?>
    <?php
    include 'header.php';
    ?>
</head>
<body>
    <h1>CONFIRMATION PAGE (WIP)</h1>
    <?php echo print_r($ticketObjects)?>
    <?php echo $HTML_ticket?>
    <form id="credentialsForm" method="POST" action="./checkout.php">
    <div  class="grid">
        <div><label for="name">Nom: </label></div>
        <div><input type="text" name="name" id="name" value="Try" require></div>
        <div><label for="email">Correu electrònic: </label></div>
        <div><input type="email" name="email" id="email" value="try@inspedralbes.cat"require></div>
        <div><label for="phone">Telèfon: </label></div>
        <div><input type="tel" name="phone" id="phone" value="123456789"require></div>
    </div>
        <button type="button" id="btn-purchase">Confirmar comanda</button>
    </form>
    <div id="ticket"><div id="total-price">0€</div></div>
    <?php 
    include 'footer.php'
    ?>
    <script type="module" src="./js/confirmation.js"></script>
    <script>swal</script>
</body>
</html>