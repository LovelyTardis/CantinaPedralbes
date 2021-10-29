<?php
session_start();
?>

<?php
    $errorMessage = ''; 
    if(isset($_COOKIE['error']))
    {
        switch (intval($_COOKIE['error'])) {
            case 5:
                # code...
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
            <div class="error-message-number"><?php  if(isset($_COOKIE['error'])){echo $_COOKIE['error']}else{echo "???"}?></div>
            <div class="error-message"><?php echo $GLOBALS['errorMessage']?></div>
        </div>
    </div>
</body>
<?php 
    include 'footer.php'
?>
</html>