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
    <title>Cantina - Confirmació</title>
    <?php
    include 'header.php';
    ?>
</head>
<body>
    <h1>CONFIRMATION PAGE (WIP)</h1>
    <form method="POST" action="./checkout.php">
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
        <button type="submit">Confirmar comanda</button>
    </form>
    <?php 
    include 'footer.php'
    ?>
</body>
<?php
    echo "<div>" . $_SESSION['ticketArray'] . "</div>";
?>
</html>