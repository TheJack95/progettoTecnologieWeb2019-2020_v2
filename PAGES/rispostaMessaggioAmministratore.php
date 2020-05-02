<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_POST['rispondi'])) {
        $_SESSION["destinatario"] = $_POST['rispondi'];
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/rispostaMessaggioAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Risposta al messaggio"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
