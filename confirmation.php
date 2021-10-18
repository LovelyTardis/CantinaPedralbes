<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Confirmació</title>
</head>
<body>
    <h1>CONFIRMATION PAGE (WIP)</h1>
    <form method="POST" action="./checkout.php">
    <table>
        <tr>
            <td><label for="name">Nom: </label></td>
            <td><input type="text" name="name" id="name" require></td>
        </tr>
        <tr>
            <td><label for="email">Correu electrònic: </label></td>
            <td><input type="email" name="email" id="email" require></td>
        </tr>
        <tr>
            <td><label for="phone">Telèfon: </label></td>
            <td><input type="tel" name="phone" id="phone" require></td>
        </tr>
    </table>
        <button type="submit">Confirmar comanda</button>
    </form>

</body>
</html>