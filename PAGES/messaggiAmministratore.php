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
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Messaggi"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])) {
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $requestR = (new funzioniAmministratore())->selectMessaggiRicevuti();
        $messaggiAmm = "";
        foreach($requestR as $responseR) {
            $messaggiAmm .= "<div class='divAmm'>"."\n".
                            "<p class='pAmm'>Mittente&colon; ".$responseR->Nome." ".$responseR->Cognome." &lsqb;".$responseR->Email."&rsqb; &lsqb;".$responseR->NumeroTelefono."&rsqb;</p>"."\n".
                            "<p class='pAmm'>Messaggio&colon; ".$responseR->Messaggio."</p>"."\n";
            $requestI = (new funzioniAmministratore())->selectMessaggiInviati($responseR->IdMess);
            foreach($requestI as $responseI) {
                $messaggiAmm .= "<p class='pAmm'>Oggetto&colon; ".$responseI->Oggetto."</p>"."\n".
                                "<p class='pAmm'>Risposta&colon; ".$responseI->Messaggio."</p>"."\n";
            }
            if(count($requestI) == 0) {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">
                                    <fieldset>
                                        <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">RISPONDI</button>
                                    </fieldset>
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">
                                    <fieldset>
                                        <button type=\"submit\" name=\"eliminaMessaggio\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">ELIMINA MESSAGGIO</button>
                                    </fieldset>
                                </form>"."\n".
                            "</div>";
            } else {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">\n
                                    <fieldset>
                                        <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">RISPONDI</button>\n
                                    </fieldset>
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">\n
                                    <fieldset>
                                        <button type=\"submit\" name=\"eliminaConversazione\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">ELIMINA CONVERSAZIONE</button>\n
                                    </fieldset>
                                </form>"."\n"
                            ."</div>";
            }
        }
        if(count($requestR) == 0) {
            $messaggiAmm .= "<p class='msgAmm'>Al momento non ci sono messaggi ricevuti</p>";
        }
        $output = str_replace("<messaggiAmministratore></messaggiAmministratore>",$messaggiAmm,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="messaggiAmministratore.php" tabindex="9">MESSAGGI</a>','&gt; MESSAGGI',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
