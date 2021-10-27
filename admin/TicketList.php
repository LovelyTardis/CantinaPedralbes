
<?php
        $products = json_decode(file_get_contents("../products.json"),true);
        $ticketJson = file_get_contents("../tickets.json");
        $tickets = json_decode($ticketJson,true);
        $ticketHTML = LoadTickets($tickets);
        function LoadTickets($tickets) : string
        {
            $str = "";
            $str .= "<div class ='general-background'><div id='ticket-box' class='grid-tickets'>";
        
            for ($i=0; $i < count($tickets); $i++) { 
                $str .= CellProduct($tickets[$i]);
            }         

            $str .="</div></div>"; 
            return $str;
        }

        function CellProduct($ticket) : string
        {
            
            $ticketCell = "";
            $ticketCell .= "<div class='cell-ticket' id='".$ticket['email']."'>";
            $ticketCell = "<h1>Ticket - ".$ticket['email']."</h1>";
            $ticketCell .= "<div class='cell-ticket-username'>Usuari: ".$ticket['username']."</div>";
            $ticketCell .= "<div class='cell-ticket-email'>Email: ".$ticket['email']."</div>";
            $ticketCell .= "<div class='cell-ticket-phone'>Telèfon: ".$ticket['phone']."</div>";
            $ticketCell .= "<div class='ticket-products'>";
            for ($x=0; $x < count($ticket['products']); $x++) { 
                $index = array_search($ticket['products'][$x]['productId'], array_column($GLOBALS['products'], 'id'));
                if($index > -1)
                {
                    $ticketCell .= "<div class='ticket-products' id='".$ticket['products'][$x]['productId']."'>";
                    $ticketCell .= "<span>".$ticket['products'][$x]['quantity']."x</span>";
                    $ticketCell .= "<span> | ".$GLOBALS['products'][$index]['productName']."</span>";
                    $ticketCell .= "</div>";
                }

            }
            $ticketCell .= "</div>";
            $ticketCell .= "<div class='cell-ticket-totalPrice'></div>";
            $ticketCell .= "</div>";
            return $ticketCell;
        }
    ?>

<!DOCTYPE html>
<html lang="en">
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