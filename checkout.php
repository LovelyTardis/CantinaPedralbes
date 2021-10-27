<?php
    session_start();
    if(isset($_COOKIE['comanda']))
    {
        //cambiar a cantina cuando se suba
        setcookie("error", "201", strtotime('today 23:59'), '/');
        header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
    }
?>

<?php    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {  
        $userName = $_POST["name"];
        $userEmail = $_POST["email"]; 
        $phoneNumber = strlen(preg_replace("/[^0-9]/", '', $_POST["phone"]));
        if($userName == '')
        {
            setcookie("error", "101", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }
        if(!endsWith($userEmail , "@inspedralbes.cat"))
        {
            setcookie("error", "102", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }
        
        if($phoneNumber > 9 || $phoneNumber < 9)
        {
            setcookie("error", "103", strtotime('today 23:59'), '/');
            header('Location: http://cantina3.alumnes.inspedralbes.cat/error.php');
            session_destroy();
        }


        setcookie("comanda", "022729", strtotime('today 23:59'), '/');
        $ticket = array("username" => $userName, "email" => $userEmail , "phone" => $phoneNumber, "products" => $_SESSION["ticketObjects"]);
        $arrayTicket = json_decode(file_get_contents("tickets.json"), true);

        mail($userEmail, "REBUT COMANDA - Cantina", $_SESSION["ticketObjects"]);
        array_push($arrayTicket, $ticket);
        file_put_contents("tickets.json", json_encode($arrayTicket, JSON_PRETTY_PRINT));
        session_destroy();
    }
    else
    {
        setcookie("error", "100", strtotime('today 23:59'), '/');
    }
    function endsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="defaultsheet" href="./css/normalize.css">
    <title>Cantina - Confirmat!</title>
    <?php
        include 'header.php';
        print_r($_SESSION["ticketObjects"]);
    ?>
</head>
<body>
    <h1>CHECKOUT PAGE (WIP)</h1>
    <p>La teva comanda ha estat realitzada correctament.</p>
    <a href="./index.php">
        <input type="button" value="Tornar al menú inicial">
    </a>
    <?php 
        include 'footer.php'
    ?>
    <script>

</script>
</body>
</html>