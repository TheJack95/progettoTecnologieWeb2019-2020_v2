<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $requestR = (new funzioniAmministratore())->selectMessaggiRicevuti();
        $messaggiAmm = "";
        foreach($requestR as $responseR) {
            $messaggiAmm .= "<div class='divAmm'>"."\n".
                            "<p class='pAmm'>Mittente&#58; ".$responseR->Nome." ".$responseR->Cognome." &#91;".$responseR->Email."&#93; &#91;".$responseR->NumeroTelefono."&#93;</p>"."\n".
                            "<p class='pAmm'>Messaggio&#58; ".$responseR->Messaggio."</p>"."\n";
            $requestI = (new funzioniAmministratore())->selectMessaggiInviati($responseR->IdMess);
            foreach($requestI as $responseI) {
                $messaggiAmm .= "<p class='pAmm'>Oggetto&#58; ".$responseI->Oggetto."</p>"."\n".
                                "<p class='pAmm'>Risposta&#58; ".$responseI->Messaggio."</p>"."\n";
            }
            if(count($requestI) == 0) {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">
                                    <fieldset>
                                        <legend>Rispondi al messaggio</legend>
                                        <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">Rispondi</button>
                                    </fieldset>
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">
                                    <fieldset>
                                        <legend>Elimina messaggio</legend>
                                        <button type=\"submit\" name=\"eliminaMessaggio\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">Elimina messaggio</button>
                                    </fieldset>
                                </form>"."\n".
                            "</div>";
            } else {
                $messaggiAmm .= "<form class=\"formRispAmm\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">\n
                                    <fieldset>
                                        <legend>Rispondi alla conversazione</legend>
                                        <button type=\"submit\" name=\"rispondi\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">Rispondi</button>\n
                                    </fieldset>
                                </form>"."\n".
                                "<form class=\"formElimAmm\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">\n
                                    <fieldset>
                                        <legend>Elimina conversazione</legend>
                                        <button type=\"submit\" name=\"eliminaConversazione\" class=\"noButt linkMod\" value=\"$responseR->IdMess\">Elimina conversazione</button>\n
                                    </fieldset>
                                </form>"."\n"
                            ."</div>";
            }
        }
        if(count($requestR) == 0) {
            $messaggiAmm .= "<p class='msgAmm'>Al momento non ci sono messaggi ricevuti&#46;</p>";
        }

        $output = file_get_contents("../HTML/messaggiAmministratore.html");
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; Messaggi"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])) {
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $output = str_replace("<messaggiAmministratore></messaggiAmministratore>",$messaggiAmm,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a href="homeAmministratore.php" tabindex="7">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="messaggiAmministratore.php" tabindex="12">Messaggi</a>','&#62; Messaggi',$output);
        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>