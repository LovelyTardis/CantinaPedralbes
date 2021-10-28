<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
    }
    if(isset($_POST["basket"]) && count(json_decode($_POST["basket"])) > 0)
    {
        $ticketObjects = json_decode($_POST["basket"]);
        $_SESSION["ticketObjects"] = $ticketObjects;
    }
    else if(isset($_SESSION["ticketObjects"] ))
    {
        $ticketObjects = json_decode($_SESSION["ticketObjects"]);
    }
    else
    {
        header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
    }
?>

<?php
    $jsonProducts = json_decode(file_get_contents("products.json"));
    $total_price = 0;
    $HTML_ticket = LoadTicket($jsonProducts, $ticketObjects);

    function LoadTicket($jsonProducts, $ticketObjects)
    {
        $str = "";
        for ($x=0; $x < count($ticketObjects) ; $x++) { 
            $productObj = $ticketObjects[$x];
            $index= array_search($productObj->productId, array_column($jsonProducts, 'id'));
            $GLOBALS["total_price"] += ((floatval($jsonProducts[$index]->price) ) *$_SESSION["ticketObjects"][$x]->quantity);
            $str .= "<div id=Ticket-".$_SESSION["ticketObjects"][$x]->productId." class='product-in-ticket'>".
                "<div class='ticket-product-quantity'>".($_SESSION["ticketObjects"][$x]->quantity)."</div>".
                "<div class='ticket-product-name'>".($jsonProducts[$index]->productName)."</div>". 
                "<div class='ticket-product-price'>".( (floatval($jsonProducts[$index]->price) ) *$_SESSION["ticketObjects"][$x]->quantity)."€</div></div>";
        }
        return $str;
    }   
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/confirmation.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Cantina - Confirmació</title>

    <?php
    include 'header.php';
    ?>
</head>
<body>
    <div class="general-title">
        <button id="back-button">TORNAR</button>
        <h1>DADES DE CONTACTE</h1>
    </div>
    <div class ="general-background">
        <form id="credentialsForm" method="POST" action="./checkout.php">
                <div  class="grid">
                    <div class="label"><label for="name">Nom: </label></div>
                    <div class="input"><input type="text" name="name" id="name" require></div>
                    <div class="label"><label for="email">Correu electrònic: </label></div>
                    <div class="input"><input type="email" name="email" id="email" require></div>
                    <div class="label"><label for="phone">Telèfon: </label></div>
                    <div class="input"><input type="tel" name="phone" id="phone" require></div>
                </div>
                <button type="button" id="btn-purchase" class="confirm">CONFIRMAR COMANDA</button>
            </form>
            <div class="grid-ticket">
            <div id="ticket" >
                <?php echo $HTML_ticket?>
                <hr>
                <div class='total-container'>
                    <span class='ticket-total-text'>TOTAL :  </span>
                    <span id='total-price'><?php echo number_format($GLOBALS['total_price'],2)?> €</span>
                </div>
            </div>
        </div>
    </div>
    <?php 
    include 'footer.php'
    ?>
    <script type="module" src="./js/confirmation.js"></script>
    <script>swal</script>
</body>
</html>