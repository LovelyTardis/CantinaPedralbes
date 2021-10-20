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
    <link rel="stylesheet" href="./css/confirmation.css">
    <title>Cantina - Confirmació</title>
    <?php
    include 'header.php';
    ?>
</head>
<body>
    <h1>CONFIRMATION PAGE (WIP)</h1>
    <form method="POST" action="./checkout.php">
    <div>
        
    </div>
    <div  class="grid">
        <div><label for="name">Nom: </label></div>
        <div><input type="text" name="name" id="name" value="Albert" require></div>
        <div><label for="email">Correu electrònic: </label></div>
        <div><input type="email" name="email" id="email" value="albert@gmail.com"require></div>
        <div><label for="phone">Telèfon: </label></div>
        <div><input type="tel" name="phone" id="phone" value="123456789"require></div>
    </div>
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