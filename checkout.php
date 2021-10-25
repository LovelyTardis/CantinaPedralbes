<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        header('Location: http://localhost/error.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Confirmat!</title>
    <?php
        include 'header.php';
        print_r($_SESSION["ticketObjects"]);
    ?>
</head>
<body>
    <h1>CHECKOUT PAGE (WIP)</h1>
    <p>La teva comanda ha estat realitzada correctament.</p>
    <a href="./index.php">
        <input type="button" value="Tornar al menú inicial">
    </a>
    <?php 
        include 'footer.php'
    ?>
    <script>
    <?php
        setcookie("comanda", "022729", strtotime('today 23:59'), '/');
        $ticket = array("username" => $_POST["name"], "email" => $_POST["email"], "phone" => $_POST["phone"], "products" => $_SESSION["ticketObjects"]);

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $arrayTicket = json_decode(file_get_contents("tickets.json"), true);
            array_push($arrayTicket, $ticket);
            file_put_contents("tickets.json", json_encode($arrayTicket, JSON_PRETTY_PRINT));
        }
    ?>
</script>
</body>
</html>