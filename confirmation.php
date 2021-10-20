<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Cantina - Confirmació</title>
    <?php
        /*$jsonProducts = file_get_contents("products.json");
        $HTML_ticket = json_decode(file_get_contents("php://input"));*/
        
    ?>
    <?php
    include 'header.php';
    ?>
</head>
<body>
    <h1>CONFIRMATION PAGE (WIP)</h1>
    <?php echo $HTML_ticket?>
    <form id="credentialsForm" method="POST" action="./checkout.php">
    <table>
        <tr>
            <td><label for="name">Nom: </label></td>
            <td><input type="text" name="name" id="name" value="Albert" require></td>
        </tr>
        <tr>
            <td><label for="email">Correu electrònic: </label></td>
            <td><input type="email" name="email" id="email" value="albert@gmail.com"require></td>
        </tr>
        <tr>
            <td><label for="phone">Telèfon: </label></td>
            <td><input type="tel" name="phone" id="phone" value="123456789"require></td>
        </tr>
    </table>
        <button type="button" id="btn-purchase">Confirmar comanda</button>
    </form>
    <div id="ticket"><div id="total-price">0€</div></div>
    <?php 
    include 'footer.php'
    ?>
    <script type="module" src="./js/confirmation.js"></script>
    <script>swal</script>
</body>
</html>