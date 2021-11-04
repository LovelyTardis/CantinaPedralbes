<?php
    session_start();
?>


<?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //COMPROVACIONES
            $allProductsInfo = json_decode(file_get_contents("./products.json"),true);  
            $userName = htmlspecialchars($_POST["name"]);
            $userEmail = $_POST["email"];
            $phoneNumber = preg_replace("/[^0-9]/", '', $_POST["phone"]);
            if($userName == '')
            {
                $_SESSION['error'] = 101;
                header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            }
            else if(!endsWith($userEmail , "@inspedralbes.cat"))
            {
                $_SESSION['error'] = 102;
                header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            }
            else if(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 9)
            {
                $_SESSION['error'] = 103;
                header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            }
            else
            {
                //GENERACION DE COOKIE, TICKET Y EMAIL
                setcookie("comanda", "022729", strtotime('today 23:59'), '/');
                $newTicket = GenerateTicket($userName, $userEmail, $phoneNumber, $_SESSION["ticketObjects"]);
                SendTicketToServer($newTicket);
                SendMail($userEmail);
                
                session_destroy();
            }
        }
        else
        {
            $_SESSION['error'] = 100;
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
        }
    
    
        function SendMail($userEmail)
        {
            $mailMessage = "";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $mailMessage = "<html><body><h1>Your Ticket</h1><table style='border: 1px solid black'>";
            $totalPrice = 0;
            for ($i=0; $i < count($_SESSION["ticketObjects"]); $i++)
            { 
                $mailMessage .= "<tr>";
                $index = array_search($_SESSION["ticketObjects"][$i]->productId, array_column($GLOBALS['allProductsInfo'], 'id'));
                if($index > -1)
                {
                    $mailMessage .= "<td>".$_SESSION["ticketObjects"][$i]->quantity."x</td>";
                    $mailMessage .= "<td>".$GLOBALS['allProductsInfo'][$index]['productName']."</td>";
                    $priceTotalProduct = (floatval($GLOBALS['allProductsInfo'][$index]['price']) * floatval($_SESSION["ticketObjects"][$i]->quantity));
                    $totalPrice += $priceTotalProduct;            
                    $mailMessage .= "<td>".number_format($priceTotalProduct,2,',','.')."€</td>";
                }
                $mailMessage .= "</tr>";
                
            }
            $mailMessage .= "</table><h2>Total Price:     ".number_format($totalPrice,2,',','.') ."€</h2>";
            $mailMessage .= "</body></html>";
            mail($userEmail, "REBUT COMANDA - Cantina", $mailMessage, $headers);
        }
        
        function GenerateTicket($userName, $userEmail, $phoneNumber, $ticketObjects)
        {
            return array("username" => $userName, "email" => $userEmail , "phone" => $phoneNumber, "products" => $ticketObjects);
        }
    
        function SendTicketToServer($tickedToPush)
        {
            $today = date("m_d_y"); 
            $fileName = "./Orders/".$today."_orders.json";   
            if(!is_file($fileName))
            {
                file_put_contents($fileName, "[]");
            }
            $arrayTicket = json_decode(file_get_contents($fileName), true); 
            array_push($arrayTicket, $tickedToPush);
            file_put_contents($fileName, json_encode($arrayTicket, JSON_PRETTY_PRINT));
        }
    
        /*Escrito de internet porque la function str_ends_with no funciona en el servidor*/
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
    <title>Cantina - Comanda confirmada</title>
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