<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <?php
        include '../header.php';
    ?>
    <title>Registre</title>
</head>
<body>
    <div class="general-title">
        <button id="back-button">TORNAR</button>
        <h1>REGISTRA'T</h1>
    </div>
    <div class ="general-background">
        <form id="SignUp" method="POST" action="./logAdmin.php">
            <div  class="grid">
                <div class="label"><label for="user">Usuari: </label></div>
                <div class="input"><input type="text" name="user" id="user" require></div>
                <div class="label"><label for="password">Contrasenya: </label></div>
                <div class="input"><input type="password" name="password" id="password" require></div>
            </div>
            <button type="submit" id="btn-signup" class="confirm">Registre</button>
        </form>
    </div>
    <?php 
        include '../footer.php'
    ?>
    <script type="module" src="./js/signup.js"></script>
</body>
</html>