<?php
    if (!isset($_SESSION)) {
    session_start();
    }
    
    if(isset($_SESSION['account']))
    {
        header('Location: http://localhost/admin/administration.php');
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($_POST['user'] == '' || $_POST['password'] == '')
        {
            $_SESSION['error'] = 4000;
            header('Location: http://localhost/error.php');
        }
        $userAccounts = json_decode(file_get_contents("../adminaccounts.json"));
        $username = htmlspecialchars($_POST['user']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        array_push($userAccounts,array("username" => $username, "password" => $password));
        file_put_contents("../adminaccounts.json",json_encode($userAccounts),JSON_PRETTY_PRINT);
        $_POST = array();
    }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/logadmin.css">
    <?php 
        include '../header.php'
    ?>
    <title>Login</title>
</head>
<body>
    <div class="general-title">
        <button id="back-button">TORNAR</button>
        <h1>ENTRA AL TEU PERFIL</h1>
    </div>
    <div class ="general-background">
        <form id="Log-In" method="GET" action="./administration.php">
            <div  class="grid">
                <div class="label"><label for="user">Usuari: </label></div>
                <div class="input"><input type="text" name="user" id="user" require></div>
                <div class="label"><label for="password">Contrasenya: </label></div>
                <div class="input"><input type="password" name="password" id="password" require></div>
            </div>
            <button type="submit" id="btn-log" class="confirm">Entrar</button>
        </form>
        <form action="./signUp.php">
            <button type="submit" id="btn-sign" class="confirm">Registrar-se</button>
        </form>
    </div>
    <?php 
        include '../footer.php'
    ?>
    <script type="module" src="./js/logadmin.js"></script>
</body>
</html>