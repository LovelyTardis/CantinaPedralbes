<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Document</title>
    <?php
            $jsonProducts = file_get_contents("../products.json");
            $productsObject = json_decode($jsonProducts,true);
            $HTML_products = LoadProductsHTML($jsonProducts,$productsObject);
            function LoadProductsHTML($json, $productsLoad) : string
            {
                $str = "";
                //
                $str .="<div id ='product-list'>";
            
                for ($i=0; $i < count($productsLoad); $i++) { 
                    $str .= CellProduct($productsLoad[$i]); 
                }         
    
                $str .="</div>";
              
                //
                return $str;
            }
                    
        function CellProduct(array $product) : string
        {
            $str = "<div class='cell-product' id='".$product["id"]."'><span><img src=".$product["imageId"]."></img>".
            "<div>".$product["productName"]."</div>".
            "<hr class='hr-cell-product'>".
            "<div>".$product["price"]."€/u</div>".
            "<button type='button' class='remove'>Remove</button>".
            "<button type='button' class='activate-product'>Activate</button>".
            "<button type='button' class='deactivate-product'>Deactivate</button></span></div>";
            
            return $str;
        }
    ?>
</head>
<body>
    <?php echo $HTML_products?>
    <form  method="POST" action="./administration.php">
        <input type="submit" value=''>
        <input type="hidden" id="senderJson" name="senderJson" value='<?php echo $jsonProducts ?>'>
    </form>
    <script src="./ProductAdministration.js"></script>
</body>
</html>