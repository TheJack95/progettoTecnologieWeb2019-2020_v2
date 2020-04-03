<?php
    require_once "../PHP/funzioniGenerali.php";

    $output = file_get_contents("../HTML/registrati.html");
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Registrazione"),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

    if(!isset($_SESSION))
        session_start();

    if(isset($_SESSION['errmessage'])) {
        $output = str_replace("<messaggio></messaggio>","<p>".$_SESSION['errmessage']."</p>",$output);
    } else
        $output = str_replace("<messaggio></messaggio>","",$output);

    echo $output;

    unset($_SESSION["errmessage"]);
?>
