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
        if(isset($_SESSION["nuovoMessaggio"])) {
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $requestR = (new funzioniAmministratore())->selectMessaggiRicevuti();
        $messaggiAmm = "";
        foreach($requestR as $responseR) {
            $messaggiAmm .= "<div class='divAmm'>"."\n".
                            "<p class='pAmm'><strong>Mittente</strong>&colon; ".$responseR->Nome." ".$responseR->Cognome." &lsqb;".$responseR->Email."&rsqb; &lsqb;".$responseR->NumeroTelefono."&rsqb;</p>"."\n".
                            "<p class='pAmm'><strong>Messaggio</strong>&colon; ".$responseR->Messaggio."</p>"."\n";
            $requestI = (new funzioniAmministratore())->selectMessaggiInviati($responseR->IdMess);
            foreach($requestI as $responseI) {
                $messaggiAmm .= "<p class='pAmm'><strong>Oggetto</strong>&colon; ".$responseI->Oggetto."</p>"."\n".
                                "<p class='pAmm'><strong>Risposta</strong>&colon; ".$responseI->Messaggio."</p>"."\n";
            }
            if(count($requestI) == 0) {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">RISPONDI</button>
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"eliminaMessaggio\" class=\"noButt linkMod msgErrAmm\" value=\"$responseR->IdMess\">ELIMINA MESSAGGIO</button>
                                </form>"."\n".
                            "</div>";
            } else {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">\n
                                    <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">RISPONDI</button>\n
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">\n
                                    <button type=\"submit\" name=\"eliminaConversazione\" class=\"noButt linkMod msgErrAmm\" value=\"$responseR->IdMess\">ELIMINA CONVERSAZIONE</button>\n
                                </form>"."\n"
                            ."</div>";
            }
        }
        if(count($requestR) == 0) {
            $messaggiAmm .= "<p class='msgAmm'>Al momento non ci sono messaggi ricevuti</p>";
        }
        $output = str_replace("<messaggiAmministratore></messaggiAmministratore>",$messaggiAmm,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="messaggiAmministratore.php">MESSAGGI</a>','<strong>MESSAGGI</strong>',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
