<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Ordenar</title>
    <link rel="stylesheet" href="./css/pickup.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <?php
    include 'header.php';
    ?>
    <script>
        <?php
        
        $time = 0;
        $ticketPrice = 0;
        $jsonProducts = file_get_contents("products.json");
        $productsObject = json_decode($jsonProducts,true);
        $HTML_products = LoadProductsHTML($jsonProducts,$productsObject, $time);
        function LoadProductsHTML($json, $productsLoad, $time) : string
        {
            $str = "";
            $str .= "<div class ='general-background'><div id='product-box' class='grid-products'>";
        
            for ($i=0; $i < count($productsLoad); $i++) { 
                if(($productsLoad[$i]["allowed"] == $time || $productsLoad[$i]["allowed"] == 2) && $productsLoad[$i]["activated"] == 1)
                {
                    $str .= CellProduct($productsLoad[$i]);
                }
            }         

            $str .="</div>";
            $str .="<div class='grid-ticket'>";
            $str .="<div id='ticket'>";
            $str .= GetTicketData();
            $str .="</div><div id='total-price'>".$GLOBALS['ticketPrice']."€</div>";
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
            "<div>".$product["price"]."€/u</div>".
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
                    "<div class='ticket-product-quantity'>".($_SESSION["ticketObjects"][$i]->quantity)."</div>".
                    "<div class='ticket-product-name'>".($thisproductsObject[$index]['productName'])."</div>". 
                    "<div class='ticket-product-price'>".( (floatval($thisproductsObject[$index]['price']) ) *$_SESSION["ticketObjects"][$i]->quantity)."€</div></div>";
                    $GLOBALS['ticketPrice'] = $GLOBALS['ticketPrice'] + ( (floatval($thisproductsObject[$index]['price']) ) *$_SESSION["ticketObjects"][$i]->quantity);
                }
                return $str;
            }
            return "";
        }
        ?>
    </script>
</head>

<body>
    <?php echo $HTML_products ?>
    <form id="form-basket" method="POST" action="./confirmation.php">
        <button type="button" id="purchase-button" value="">Comprar</button>
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

