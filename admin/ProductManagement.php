<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <link rel="defaultsheet" href="../css/normalize.css">
    <link rel="stylesheet" href="./css/productmanagment.css">
    <title>Administrar productes</title>
    <?php
            $jsonProducts = file_get_contents("../products.json");
            $productsObject = json_decode($jsonProducts,true);
            $HTML_products = LoadProductsHTML($jsonProducts,$productsObject);
            function LoadProductsHTML($json, $productsLoad) : string
            {
                $str = "";
                //
                $str .= "<div id ='product-list'>";
                for ($i=0; $i < count($productsLoad); $i++) { 
                    $str .= CellProduct($productsLoad[$i]); 
                }         
    
                $str .="</div>"; 
                //
                return $str;
            }
                    
        function CellProduct(array $product) : string
        {
            $str = "<div class='item-container'><div class='cell-product' id='".$product["id"]."'><span><img src=".$product["imageId"]."></img>".
            "<div class='product-name'>".$product["productName"]."</div>".
            "<div class='product-price'>".$product["price"]."€/u</div>".
            "<div class='button-container'><button type='button' class='remove'>Remove</button>".
            "<button type='button' class='activate-product'>Activate</button>".
            "<button type='button' class='deactivate-product'>Deactivate</button></span></div></div></div>";
            return $str;
        }
    ?>
</head>
<body>

    <?php
    include '../header.php';
    ?>
    <div class='general-title'>
        <button id='back-button'>TORNAR</button>
        <h1>GESTIONA ELS PRODUCTES</h1>
    </div>
    <div class='general-background'>
        <?php echo $HTML_products?>
        <form  method="POST" action="./administration.php">
            <input type="submit" value="Guardar Canvis" class="save-button">
            <input type="hidden" id="senderJson" name="senderJson" value='<?php echo $jsonProducts ?>'>
        </form>
    </div>
    <?php 
    include '../footer.php';
    ?>
    <script src="./js/ProductManagement.js"></script>
</body>
</html>