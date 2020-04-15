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
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; NUOVO MESSAGGIO"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);

        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);

        echo $output;
    } else {
        $message = "Attenzione&colon; non hai i permessi per accedere all&apos;area personale e sei stato reindirizzato alla pagina per accedere&excl;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
