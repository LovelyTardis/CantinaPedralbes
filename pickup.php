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
    <link rel="stylesheet" href=".css/pickup.css">
    <?php
    include 'header.php';
    ?>
    <script>
        <?php
        
        $jsonProducts = file_get_contents("products.json");
        $productsObject = json_decode($jsonProducts,true);
        $HTML_products = LoadProductsHTML($jsonProducts,$productsObject);
        function LoadProductsHTML($json, $productsLoad) : string
        {
            $str = "";
            //
            $str .="<table id='product-box'><tr>";
        
            for ($i=0; $i < count($productsLoad); $i++) { 
                $str .= CellProduct($productsLoad[$i]);
            }         

            $str .="</tr></table>";
            $str .= "<input type='hidden' id='JsonProducts' value='".$json."' />";

            //
            return $str;
            
        }

        function CellProduct(array $product) : string
        {
            return "<td><div><p>id:".$product["id"]."</p>".
            "<p>Nombre:".$product["productName"]."<p>".
            "<p><span>Precio:".$product["price"]."</span><p></div>".
            "<div><p><button value=".$product["id"]." type='button' class='Decrease'  disabled>-</button><span>0</span><button value=".$product["id"]." type='button' class='Increase'>+</button></p></div></td>";
        }

        $_SESSION['ticketArray'] = "";
        ?>
    </script>
</head>

<body>
    <h1>PICKUP PAGE (WIP)</h1>
    <?php echo $HTML_products ?>
    <form method="POST" action="./confirmation.php">
        
        <button type="submit">Següent</button>
    </form>
    <div id="ticket"></div>
    <?php 
    include 'footer.php'
    ?>
    <script src="/js/pickup.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>

