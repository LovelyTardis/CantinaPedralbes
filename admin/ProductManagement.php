<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <link rel="defaultsheet" href="../css/normalize.css">
    <link rel="stylesheet" href="./css/productmanagment.css">
    <title>Product Managment</title>
    <?php
            $jsonProducts = file_get_contents("../products.json");
            $productsObject = json_decode($jsonProducts,true);
            $HTML_products = LoadProductsHTML($jsonProducts,$productsObject);
            function LoadProductsHTML($json, $productsLoad) : string
            {
                $str = "";
                //
                $str .= "<div class='general-title'>";
                $str .= "<button id='back-button'>TORNAR</button>";
                $str .= "<h1>GESTIONA ELS PRODUCTES</h1></div>";
                $str .= "<div class='general-background'><div id ='product-list'>";
                for ($i=0; $i < count($productsLoad); $i++) { 
                    $str .= CellProduct($productsLoad[$i]); 
                }         
    
                $str .="</div></div>"; 
                //
                return $str;
            }
                    
        function CellProduct(array $product) : string
        {
            $str = "<div class='item-container'><div class='cell-product' id='".$product["id"]."'><span><img src=".$product["imageId"]."></img>".
            "<div class='product-name'>".$product["productName"]."</div></div>".
            "<div class='product-price'>".$product["price"]."€/u</div>".
            "<div class='button-container'><button type='button' class='remove'>Remove</button>".
            "<button type='button' class='activate-product'>Activate</button>".
            "<button type='button' class='deactivate-product'>Deactivate</button></span></div></div>".
            "<hr class='hr-cell-product'>";
            return $str;
        }
    ?>
</head>
<body>

    <?php
    include '../header.php';
    ?>
    
    <?php echo $HTML_products?>
    <div class="general-title">
        <button id="back-button">TORNAR</button>
        <h1>AFEGEIX UN PRODUCTE</h1>
    </div>
    <form  method="POST" action="./administration.php">
        <input type="submit" value=''>
        <input type="hidden" id="senderJson" name="senderJson" value='<?php echo $jsonProducts ?>'>
    </form>
    <?php 
    include '../footer.php';
    ?>
    <script src="./ProductManagement.js"></script>
</body>
</html>