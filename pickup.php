<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Ordenar</title>
    <?php
    $HTML_products = "";
    $products = file_get_contents("products.json");
    $products = json_decode($products,true);
    $HTML_products = LoadProductsHTML($products);
    function LoadProductsHTML($productsLoad) : string
    {
        $str = "";
        //
        $str .="<table>";
        for ($i=0; $i < count($productsLoad); $i++) { 
            $str .="<tr><td>id:".$productsLoad[$i]["id"]."</td>".
            "<td>Nombre:".$productsLoad[$i]["productName"]."</td>".
            "<td>Precio:".$productsLoad[$i]["price"]."</td></tr>".
            "<tr><td><button type='button' class='restar'>-</button><span id=".$productsLoad[$i]["id"].">0</span><button type='button' class='sumar'>+</button></td></tr>";
        }
        $str .="</table>";
        //
        return $str;
    }
    
    ?>
</head>

<body>
    <h1>PICKUP PAGE (WIP)</h1>
    <?php echo $HTML_products ?>
    <form method="POST" action="./confirmation.php">
        <button type="submit">Següent</button>
    </form>
</body>
</html>

