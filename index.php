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
    <h1>LANDING PAGE (WIP)</h1>
    <a>
        <input type="button" id="continue-button" value="Començar comanda">
    </a>
    <?php 
    include 'footer.php'
    ?>
    <script src="/js/index.js"></script>
</body>
</html>