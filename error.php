<?php
session_start();
?>

<?php
    $errorMessage = ''; 
    if(isset($_COOKIE['error']))
    {
        switch (intval($_COOKIE['error'])) {
            case 0:
                $errorMessage = "No hi ha cap error i no hauries d'estar aquí.";
                break;
            case 100:
                $errorMessage = "Ja has fet una comanda avui!";
                break;
            case 101:
                $errorMessage = "El nom no pot estar buit.";
                break;
            case 102:
                $errorMessage = "La direcció de correu no és correcta. El domini ha de ser '@inspedralbes.cat'.";
                break;
            case 103:
                $errorMessage = "El format de número de telèfon introduït no és correcte. Ha de tenir 9 dígits.";
                break;
            case 200:
                $errorMessage = "No hi ha res a la comanda!";
                break;
            case 201:
                $errorMessage = "Vols confirmar una comanda que no has fet?";
                break;
            default:
                $errorMessage = 'Error no registrat al servidor!'; 
                break;
        }
    }
    else
    {
        $errorMessage = 'Error desconegut!'; 
    }

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <?php 
        include 'header.php'
    ?>
</head>
<body>
    <div class ="general-background">
        <div class="error-box">
            <div class="error-message-number">Codi error: <?php if(isset($_COOKIE['error'])){echo $_COOKIE['error'];}else{echo "???";}?></div>
            <div class="error-message"><?php echo $GLOBALS['errorMessage']?></div>
        </div>
    </div>
</body>
<?php 
    include 'footer.php'
?>
</html>