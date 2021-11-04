
<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if(isset($_SESSION['account']))
    {
        $userAccounts = json_decode(file_get_contents("../adminaccounts.json"));
        $index = array_search($_SESSION['account']->username, array_column($userAccounts, 'username'));
        if($index > -1)
        {
            if($_SESSION['account']->password != $userAccounts[$index]->password)
            {
                $_SESSION['error'] = 4003;
                header('Location: http://localhost/error.php');      
            }
        }
        else
        {
            $_SESSION['error'] = 4005;
            header('Location: http://localhost/error.php');
        }
    }
    else
    {
        header('Location: http://localhost/admin/logAdmin.php');
    }

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
        $ticketHTML = "<h1 class='no-ticket'>No hi ha Tickets</h1>";
    }
    function LoadTickets($tickets) : string
    {
        $str = "";
        $str .= "<div id='ticket-box' class='grid-tickets'>";
    
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
        $ticketCell .= "<h2>Ticket</h2>";
        $ticketCell .= "<div class='cell-ticket-username'><b>Usuari:</b> ".$ticket['username']."</div>";
        $ticketCell .= "<div class='cell-ticket-email'><b>Email:</b> ".$ticket['email']."</div>";
        $ticketCell .= "<div class='cell-ticket-phone'><b>Telèfon:</b> ".$ticket['phone']."</div>";
        $ticketCell .= "<hr><div class='ticket-products-table'>";
        $ticketCell .= "<h3>Comanda:</h3>";
        for ($x=0; $x < count($ticket['products']); $x++) { 
            $index = array_search($ticket['products'][$x]['productId'], array_column($GLOBALS['allProductsInfo'], 'id'));
            if($index > -1)
            {
                //Vamos calculando el precio total de la comanda y del producto
                $totalPrice += floatval($GLOBALS['allProductsInfo'][$index]['price']) * $ticket['products'][$x]['quantity'];
                $totalProductPrice = number_format(floatval($GLOBALS['allProductsInfo'][$index]['price']) * $ticket['products'][$x]['quantity'],2,',','.');
                //
                $ticketCell .= "<div class='ticket-product' id='".$ticket['products'][$x]['productId']."'>";
                $ticketCell .= "<span class='ticket-product-quantity'>".$ticket['products'][$x]['quantity']."x</span>";
                $ticketCell .= "<span class='ticket-product-name'>".$GLOBALS['allProductsInfo'][$index]['productName']."</span>";
                $ticketCell .= "<span class='ticket-product-total-price'>".$totalProductPrice."€</span>";
                $ticketCell .= "</div>";
            }
        }
        
        $ticketCell .= "</div>";
        $ticketCell .= "<hr>";
        $ticketCell .= "<div class='cell-ticket-totalPrice'><b>TOTAL: ".number_format($totalPrice,2,',','.')."€</b></div>";
        return $ticketCell;
    }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/ticketlist.css">
    <title>Visor tickets</title>
    <?php
    include '../header.php';
    ?>
</head>
<body>
    <div class="general-title">
        <button id="back-button">TORNAR</button>
        <h1>TICKETS</h1>
    </div>
    <div class ='general-background'>
    <?php echo $ticketHTML ?>
    </div>
    <?php 
    include '../footer.php'
    ?>
    <script src="./js/ticketlist.js"></script>
</body>
</html>