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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <form id="Log-In" method="GET" action="./administration.php">
        <div  class="grid">
            <div class="label"><label for="user">Usuari: </label></div>
            <div class="input"><input type="text" name="user" id="user" require></div>
            <div class="label"><label for="password">Contraseña: </label></div>
            <div class="input"><input type="password" name="password" id="password" require></div>
        </div>
        <button type="submit" id="btn-log" class="login">LogIn</button>
    </form>
    <form action="./signUp.php">
        <button type="submit" id="btn-log" class="signUp">signUp</button>
    </form>
</body>
</html>