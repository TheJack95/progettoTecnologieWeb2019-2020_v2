<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $messaggio = "";

        $output = file_get_contents("../HTML/nuovoMessaggioAmministratore.html");
        
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Nuovo messaggio"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        $output = str_replace("<messaggio></messaggio>",$messaggio,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        
        $output = str_replace('<a class="" href="areaPrivata.php">AREA PERSONALE</a>','<a class="" href="homeAmministratore.php">AREA PERSONALE</a>',$output);

        echo $output;
    } else {
        $message = "Attenzione&colon; non hai i permessi per accedere all&apos;area personale e sei stato reindirizzato alla pagina per accedere&excl;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
