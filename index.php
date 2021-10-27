<?php
session_start();
setcookie("error", "0", strtotime('today 23:59'), '/');
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="defaultsheet" href="./css/normalize.css">
    <script src="/SweetAlert2/dist/sweetalert2.all.min.js"></script>
    <title>Cantina - Inici</title>
    <?php
        if(isset($_SESSION["ticketObjects"]))
        {
            $_SESSION["ticketObjects"] = [];
        }
    ?>
    <?php
        include 'header.php';
    ?>
</head>
<body>
    <div class="general-background">
        <h1 class="title">BENVINGUTS A LA CANTINA!</h1>
        <img src="./assets/images/test.jpg" alt="Cantina Pedralbes">
         <div class="button-container">
             <input type="button" id="continue-button" value="Començar comanda">
         </div>
    </div>
    <?php 
    include 'footer.php'
    ?>
    <script src="/js/index.js"></script>
</body>
</html>