<?php
    require_once "../PHP/funzioniGenerali.php";

    $output = file_get_contents("../HTML/registrati.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Registrazione"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

    if(!isset($_SESSION))
        session_start();

    if(isset($_SESSION['errmessage'])) {
        $output = str_replace("<messaggio></messaggio>","<p class='errorMessage'>".$_SESSION['errmessage']."</p>",$output);
    } else
        $output = str_replace("<messaggio></messaggio>","",$output);

    echo $output;

    unset($_SESSION["errmessage"]);
?>
