<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";
    
    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $requestR = (new funzioniAmministratore())->selectMessaggiRicevuti();
        $ricevuti = "";

        foreach($requestR as $responseR) {
            $ricevuti .= "<ul>"
                        ."  <li>Nome&colon; <strong>".$responseR->Nome."</strong></li>"
                        ."  <li>Cognome&colon; <strong>".$responseR->Cognome."</strong></li>"
                        ."  <li>NumeroTelefono&colon; <strong>".$responseR->NumeroTelefono."</strong></li>"
                        ."  <li>Email&colon; <strong>".$responseR->Email."</strong></li>"
                        ."  <li>Messsaggio&colon; <strong>".$responseR->Messaggio."</strong></li>"
                        ."</ul>";
        }
        if(count($requestR) == 0) {
            $ricevuti .= "<p class=\"\">Al momento non ci sono messaggi ricevuti&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $requestI = (new funzioniAmministratore())->selectMessaggiInviati();
        $inviati = "";

        foreach($requestI as $responseI) {
            $inviati .= "<ul>".
                        "  <li>Email Mittente&colon; <strong>".$responseI->Email."</strong></li>".
                        "  <li>Email Destinatario&colon; <strong>".$responseI->EmailDestinatario."</strong></li>".
                        "  <li>Oggetto&colon; <strong>".$responseI->Oggetto."</strong></li>".
                        "  <li>Messsaggio&colon; <strong>".$responseI->Messaggio."</strong></li>".
                        "</ul>";
        }
        if(count($requestI) == 0) {
            $inviati .= "<p class=\"\">Al momento non ci sono messaggi inviati&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $output = file_get_contents("../HTML/messaggiAmministratore.html");
    
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Messaggi"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        $output = str_replace("<messaggiRicevuti></messaggiRicevuti>",$ricevuti,$output);
        $output = str_replace("<messaggiInviati></messaggiInviati>",$inviati,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    
        $output = str_replace('<a class="" href="areaPrivata.php">AREA PERSONALE</a>','<a href="homeAmministratore.php">AREA PERSONALE</a>',$output);
        $output = str_replace('<a href="messaggiAmministratore.php">MESSAGGI</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>MESSAGGI</strong>',$output);

        echo $output;
    } else {
        $message = "Attenzione&colon; non hai i permessi per accedere all&apos;area personale e sei stato reindirizzato alla pagina per accedere&excl;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
