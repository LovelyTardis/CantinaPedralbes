<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        $jsonProducts = file_get_contents("products.json");
        $productsObject = json_decode($jsonProducts,true);
        $HTML_products = LoadProductsHTML($jsonProducts,$productsObject, $time);
        function LoadProductsHTML($json, $productsLoad, $time) : string
        {
            $str = "";
            //
            $str .="<div class ='general-background'><div id='product-box' class='grid-products'>";
        
            for ($i=0; $i < count($productsLoad); $i++) { 
                if($productsLoad[$i]["allowed"] == $time || $productsLoad[$i]["allowed"] == 2)
                {
                    $str .= CellProduct($productsLoad[$i]);
                }
            }         

            $str .="</div>";
            $str .="<div class='grid-ticket'>";
            for ($i=0; $i < count($productsLoad); $i++) { 
                if($productsLoad[$i]["allowed"] == $time || $productsLoad[$i]["allowed"] == 2)
                {
                    $str .= CellProduct($productsLoad[$i]);
                }
            }  
            $str .="</div></div>";
            $str .= "<input type='hidden' id='JsonProducts' value='".$json."' />";
            
            //
            return $str;
            
        }
        
        function CellProduct(array $product) : string
        {
            return "<div class='cell-product' id='".$product["id"]."'><div><img src=".$product["imageId"]."></img>".
            "<div>".$product["productName"]."</div>".
            "<hr class='hr-cell-product'>".
            "<div>".$product["price"]."€/u</div>".
            "<hr class='hr-cell-product'>".
            "<div class='quantity-value'>0</div></div>".
            "<div><button type='button' class='decrease'  disabled>-</button><button type='button' class='increase'>+</button></div></div>";
        }
        $_SESSION['ticketArray'] = "";
        ?>
    </script>
</head>

<body>
    <h1>PICKUP PAGE (WIP)</h1>
    <?php echo $HTML_products ?>
    <form method="POST" action="./confirmation.php">
        <button type="button" id="purchase-button" value="">Comprar</button>
        <button type="submit">Següent</button>
        <input type='hidden' id='basket-product-php' name="compra" value='' />
    </form>
    <div id="ticket">
        <div id="total-price">

        </div>
    </div>
    <?php 
    include 'footer.php'
    ?>
    <script src="/js/pickup.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>

