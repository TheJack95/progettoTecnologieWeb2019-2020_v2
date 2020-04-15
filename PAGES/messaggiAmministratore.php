<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/messaggiAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; MESSAGGI"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }

        $requestR = (new funzioniAmministratore())->selectMessaggiRicevuti();
        $ricevuti = "";
        foreach($requestR as $responseR) {
            $ricevuti .= "<p>Nome e cognome&colon; <strong>".$responseR->Nome." ".$responseR->Cognome."</strong></p>"."\n"
                        ."<p>Contatti&colon; <strong>".$responseR->NumeroTelefono." ".$responseR->Email."</strong></p>"."\n"
                        ."<p>Messsaggio&colon; <strong>".$responseR->Messaggio."</strong></p>"."\n"
                        ."<a class=\"tastoModifiche\" href=\"../PAGES/rispostaMessaggioAmministratore.php\">RISPONDI</a>";
        }
        if(count($requestR) == 0) {
            $ricevuti .= "<p class=\"msgAmm\">Al momento non ci sono messaggi ricevuti&comma; riprova pi&ugrave; tardi&period;</p>";
        }
        $output = str_replace("<messaggiRicevuti></messaggiRicevuti>",$ricevuti,$output);

        $requestI = (new funzioniAmministratore())->selectMessaggiInviati();
        $inviati = "";

        foreach($requestI as $responseI) {
            $inviati .= "<p>Email Mittente&colon; <strong>".$responseI->Email."</strong></p>"."\n".
                        "<p>Email Destinatario&colon; <strong>".$responseI->EmailDestinatario."</strong></p>"."\n".
                        "<p>Oggetto&colon; <strong>".$responseI->Oggetto."</strong></p>"."\n".
                        "<p>Messsaggio&colon; <strong>".$responseI->Messaggio."</strong></p>"."\n";
        }
        if(count($requestI) == 0) {
            $inviati .= "<p class=\"msgAmm\">Al momento non ci sono messaggi inviati&comma; riprova pi&ugrave; tardi&period;</p>";
        }
        $output = str_replace("<messaggiInviati></messaggiInviati>",$inviati,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="messaggiAmministratore.php">MESSAGGI</a>','<strong>MESSAGGI</strong>',$output);

        echo $output;
    } else {
        $message = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
