<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <form id="SignUp" method="POST" action="./logAdmin.php">
        <div  class="grid">
            <div class="label"><label for="user">Usuari: </label></div>
            <div class="input"><input type="text" name="user" id="user" require></div>
            <div class="label"><label for="password">Contraseña: </label></div>
            <div class="input"><input type="password" name="password" id="password" require></div>
        </div>
        <button type="submit" id="btn-signup" class="SignUp">SignUp</button>
    </form>
</body>
</html>