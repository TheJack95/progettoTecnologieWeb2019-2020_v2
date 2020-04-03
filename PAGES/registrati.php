<?php
    require_once "../PHP/funzioni.php";

    $output = file_get_contents("../HTML/registrati.html");
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Registrazione"),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

    if(!isset($_SESSION))
        session_start();

    if(isset($_SESSION['registrazione'])) {
        $class = $_SESSION['registrazione']->status ? "messaggio" : "errorMessage";
        $output = str_replace("<messaggio></messaggio>","<p class='$class'>".$_SESSION['registrazione']->response."</p>",$output);
    } else
        $output = str_replace("<messaggio></messaggio>","",$output);

    echo $output;

    unset($_SESSION["registrazione"]);
?>