<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Comanda</title>
    <link rel="stylesheet" href="./css/pickup.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <?php
    include 'header.php';
    ?>
    <?php
    date_default_timezone_set("Europe/Madrid");
    $actualTime = "today " . date("G:i", time());
    $time = "";
    if (strtotime($actualTime) <= strtotime("today 11:30")) { $time = 0; }
    else { $time = 1; }
    
    $ticketPrice = 0;
    $jsonProducts = file_get_contents("products.json");
    $productsObject = json_decode($jsonProducts,true);
    $HTML_products = LoadProductsHTML($jsonProducts,$productsObject, $time);
    function LoadProductsHTML($json, $productsLoad, $time) : string
    {
        $str = "";

        //Title for the schedule
        $str .= "<div class ='general-title'>";
        $str .= "<button id='back-button'>TORNAR</button><h1>MENÚ DEL ";
        if($time == 0){ $str .= "MATÍ"; }
        else{ $str .= "MIGDIA"; }
        $str .= "</h1></div>";
        $str .= "<div class ='general-background'><div id='product-box' class='grid-products'>";
        for ($i=0; $i < count($productsLoad); $i++) { 
            if(($productsLoad[$i]["allowed"] == $time || $productsLoad[$i]["allowed"] == 2) && $productsLoad[$i]["activated"] == 1)
            {
                $str .= CellProduct($productsLoad[$i]);
            }
        }         

        $str .="</div>";
        $str .="<div class='grid-ticket'>";
        $str .="<div class='title-ticket'><h1>COMANDA</h1></div>";
        $str .="<div id='ticket'>";
        $str .= GetTicketData();
        $str .="</div><hr><div class='total-container'><span class='ticket-total-text'>TOTAL :  </span><span id='total-price'>".$GLOBALS['ticketPrice']."€</span></div>";
        $str .= "<div class='buy-button'><button type='button' id='purchase-button' value=''>COMPRAR</button></div>";
        $str .= "</div></div>";
        $str .= "<input type='hidden' id='JsonProducts' value='".$json."' />";

        //
        return $str;
        
    }
    
    function CellProduct(array $product) : string
    {
        $str = "<div class='cell-product' id='".$product["id"]."'><div><img src=".$product["imageId"]."></img>".
        "<div>".$product["productName"]."</div>".
        "<hr class='hr-cell-product'>".
        "<div>".number_format(floatval($product["price"]),2,',')."€/u</div>".
        "<hr class='hr-cell-product'>".
        ServerInfoProduct($product["id"]);
        
        return $str;
    }
    function ServerInfoProduct($id) : string
    {
        $str = "<div class='quantity-value'>0 ud/s</div></div>".
        "<div><button type='button' class='decrease'  disabled>-</button><button type='button' class='increase'>+</button></div></div>";;
        if(isset($_SESSION["ticketObjects"]))
        {
            $index = array_search($id, array_column($_SESSION["ticketObjects"], 'productId'));
            if($index !== false)
            {
                $str = "<div class='quantity-value'>".$_SESSION["ticketObjects"][$index]->quantity." ud/s</div></div>".
                "<div><button type='button' class='decrease'>-</button><button type='button' class='increase'>+</button></div></div>";
            }
        }   
        return $str;
    }
    function GetTicketData() : string
    {
        if(isset($_SESSION["ticketObjects"]))
        {
            $thisjsonProducts = file_get_contents("products.json");
            $thisproductsObject = json_decode($thisjsonProducts,true);
            $str = "";
            for ($i=0; $i < count($_SESSION["ticketObjects"]); $i++) { 
                
                $index = array_search($_SESSION["ticketObjects"][$i]->productId, array_column($thisproductsObject, 'id'));
                
                $str .= "<div id=Ticket-".$_SESSION["ticketObjects"][$i]->productId." class='product-in-ticket'>".
                "<div class='ticket-product-quantity'>".($_SESSION["ticketObjects"][$i]->quantity)."x</div>".
                "<div class='ticket-product-name'>".($thisproductsObject[$index]['productName'])."</div>". 
                "<div class='ticket-product-price'>".number_format(( (floatval($thisproductsObject[$index]['price']) ) *$_SESSION["ticketObjects"][$i]->quantity),2,',')."€</div></div>";
                $GLOBALS['ticketPrice'] = number_format((floatval($GLOBALS['ticketPrice']) + ( (floatval($thisproductsObject[$index]['price']) ) *$_SESSION["ticketObjects"][$i]->quantity)),2,',');
            }
            return $str;
        }
        return "";
    }
    ?>
</head>

<body>
    <?php echo $HTML_products ?>
    <form id="form-basket" method="POST" action="./confirmation.php">
        <input type='hidden' id='basket-product-php' name="basket" value=<?php if(isset($_SESSION["ticketObjects"])){ echo json_encode($_SESSION['ticketObjects']); } else {echo '[]';}?> />
    </form>
    <?php 
    include 'footer.php'
    ?>
    <script src="/js/pickup.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>

