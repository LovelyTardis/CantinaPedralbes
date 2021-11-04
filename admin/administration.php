<?php
    if (!isset($_SESSION)) {
        session_start();
    }
////login
    $userAccounts = json_decode(file_get_contents("../adminaccounts.json"));
    if(isset($_SESSION['account']))
    {
        $userAccounts = json_decode(file_get_contents("../adminaccounts.json"));
        $index = array_search($_SESSION['account']->username, array_column($userAccounts, 'username'));
        if($index > -1)
        {
            if($_SESSION['account']->password != $userAccounts[$index]->password)
            {
                $_SESSION['error'] = 4003;
                header('Location: http://localhost/error.php');      
            }
        }
        else
        {
            $_SESSION['error'] = 4005;
            header('Location: http://localhost/error.php');
        }
    }
    else if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if($_GET['user'] == '' || $_GET['password'] == '')
        {
            $_SESSION['error'] = 4001;
            header('Location: http://localhost/error.php');
        }

        $username = htmlspecialchars($_GET['user']);
        $password = htmlspecialchars($_GET['password']);
        $index = array_search($username, array_column($userAccounts, 'username'));
        if($index > -1)
        {
            if(password_verify($password,$userAccounts[$index]->password))
            {
                $_SESSION['account'] = $userAccounts[$index];
            }
            else
            {
                $_SESSION['error'] = 4003;
                header('Location: http://localhost/error.php');  
            }
        }
        else
        {
            $_SESSION['error'] = 4002;
            header('Location: http://localhost/error.php');
        }
        $_GET = array();
    }
    else
    {
        header('Location: http://localhost/admin/logAdmin.php');
    }
?>



<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="../css/normalize.css">
    <link rel="stylesheet" href="./css/administration.css">

    <title>Cantina - Administració</title>
    <?php
    include '../header.php';
    ?>
    <?php
        if(isset($_POST['senderJson']))
        {
            file_put_contents("../products.json", json_encode(json_decode($_POST['senderJson']), JSON_PRETTY_PRINT));
        }
    ?>
</head>
<body>
    <div class="general-background" id="navigation">
        <div class="button">
            <input type="button" id="product-admin" value="Agregar Productes">
        </div>
        <div class="button">
            <input type="button" id="product-manage" value="Administrar Productes">
        </div>
        <div class="button">
            <input type="button" id="ticket-admin" value="Mostrar Tickets">
        </div>
    </div>
    
    <?php 
    include '../footer.php';
    ?>
    <script src="./js/administration.js"></script>
</body>
</html>