
<?php
        $today = date("m_d_y"); 
        $fileName = "../Orders/".$today."_orders.json";   
        $ticketHTML = "";
        if(is_file($fileName))
        {
            $allProductsInfo = json_decode(file_get_contents("../products.json"),true);        
            $ticketJson = file_get_contents($fileName);
            $tickets = json_decode($ticketJson,true);
            $ticketHTML = LoadTickets($tickets);
        }
        else
        {
            $ticketHTML = "<h1>No hi ha Tickets</h1>";
        }
        function LoadTickets($tickets) : string
        {
            $str = "";
            $str .= "<div class ='general-background'><div id='ticket-box' class='grid-tickets'>";
        
            for ($i=0; $i < count($tickets); $i++) { 
                $str .= CellTicket($tickets[$i]);
            }         

            $str .="</div></div>"; 
            return $str;
        }

        function CellTicket($ticket) : string
        {
            $totalPrice = 0;
            $ticketCell = "";
            $ticketCell = "<div class='user-ticket'>";
            $ticketCell .= "<h1>Ticket - ".$ticket['email']."</h1>";
            $ticketCell .= "<div class='cell-ticket-username'>Usuari: ".$ticket['username']."</div>";
            $ticketCell .= "<div class='cell-ticket-email'>Email: ".$ticket['email']."</div>";
            $ticketCell .= "<div class='cell-ticket-phone'>Telèfon: ".$ticket['phone']."</div>";
            $ticketCell .= "<div class='ticket-products'>";
            for ($x=0; $x < count($ticket['products']); $x++) { 
                $index = array_search($ticket['products'][$x]['productId'], array_column($GLOBALS['allProductsInfo'], 'id'));
                if($index > -1)
                {
                    //Vamos calculando el precio total de la comanda y del producto
                    $totalPrice += floatval($GLOBALS['allProductsInfo'][$index]['price']) * $ticket['products'][$x]['quantity'];
                    $totalProductPrice = round(floatval($GLOBALS['allProductsInfo'][$index]['price']) * $ticket['products'][$x]['quantity'],2);
                    //
                    $ticketCell .= "<div class='ticket-products' id='".$ticket['products'][$x]['productId']."'>";
                    $ticketCell .= "<span class='ticket-product-quantity'>".$ticket['products'][$x]['quantity']."x</span>";
                    $ticketCell .= "<span class='ticket-product-name'> | ".$GLOBALS['allProductsInfo'][$index]['productName']."</span>";
                    $ticketCell .= "<span class='ticket-product-total-price'> | ".$totalProductPrice."€</span>";
                    $ticketCell .= "</div>";
                }

            }
            $ticketCell .= "</div>";
            $ticketCell .= "<div class='cell-ticket-totalPrice'>TOTAL: ".round($totalPrice,2)."€</div>";
            $ticketCell .= "</div>";
            return $ticketCell;
        }
    ?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $ticketHTML ?>
</body>
</html>