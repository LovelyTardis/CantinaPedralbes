<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Confirmat!</title>
    <?php
        $tmp = file_get_contents("tickets.json");
        echo $tmp;
        $username = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // guardar ticket
            $array = array($username, $email, $phone);
            
        }
    ?>
</head>
<body>
    <h1>CHECKOUT PAGE (WIP)</h1>
    <p>La teva comanda ha estat realitzada correctament.</p>
    <a href="./index.html">
        <input type="button" value="Tornar al menú inicial">
    </a>
</body>
</html>