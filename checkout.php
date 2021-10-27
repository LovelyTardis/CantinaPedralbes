<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        setcookie("error", "201", strtotime('today 23:59'), '/');
        header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
    }
?>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $products = json_decode(file_get_contents("./products.json"),true);  
        $userName = $_POST["name"];
        $userEmail = $_POST["email"]; 
        $phoneNumber = strlen(preg_replace("/[^0-9]/", '', $_POST["phone"]));
        if($userName == '')
        {
            setcookie("error", "101", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }
        if(!endsWith($userEmail , "@inspedralbes.cat"))
        {
            setcookie("error", "102", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }
        
        if($phoneNumber > 9 || $phoneNumber < 9)
        {
            setcookie("error", "103", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }


        setcookie("comanda", "022729", strtotime('today 23:59'), '/');
        $ticket = array("username" => $userName, "email" => $userEmail , "phone" => $phoneNumber, "products" => $_SESSION["ticketObjects"]);
        $arrayTicket = json_decode(file_get_contents("tickets.json"), true);

        /////MAIL
        $mailMessage = "";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $mailMessage = "<html><body><h1>Your Ticket</h1><table>";

        for ($i=0; $i < count($_SESSION["ticketObjects"]); $i++)
        { 
            $mailMessage .= "<tr>";
            $index = array_search($_SESSION["ticketObjects"][$i]->productId, array_column($GLOBALS['products'], 'id'));
            if($index > -1)
            {
                $mailMessage .= "<td>".$_SESSION["ticketObjects"][$i]->quantity."x</td>";
                $mailMessage .= "<td>".$GLOBALS['products'][$index]['productName']."</td>";
                $mailMessage .= "<td>".$GLOBALS['products'][$index]['price']."</td>";
            }
            $mailMessage .= "</tr>";
        }
        $mailMessage .= "</table></body></html>";
        mail($userEmail, "REBUT COMANDA - Cantina", $mailMessage, $headers);
        //////////
        array_push($arrayTicket, $ticket);
        file_put_contents("tickets.json", json_encode($arrayTicket, JSON_PRETTY_PRINT));
        session_destroy();
    }
    else
    {
        setcookie("error", "100", strtotime('today 23:59'), '/');
    }
    /*robado de internet porque la function str_ends_with no funciona en el servidor*/
    function endsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/checkout.css">
    <title>Cantina - Confirmat!</title>
    <?php
        include 'header.php';
    ?>
</head>
<body>
    <div class="general-background">
        <h1 class="titol">LA TEVA COMANDA HA ESTAT CONFIRMADA!</h1>
        <a href="./index.php">
            <input type="button" value="Tornar al menú inicial" class="confirm">
        </a>
    </div>
    <?php 
        include 'footer.php'
    ?>
</body>
</html>