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
            $messaggiAmm .= "<div class=''>"."\n"
                        ."<p>Nome e cognome&colon; <strong>".$responseR->Nome." ".$responseR->Cognome."</strong></p>"."\n"
                        ."<p>Contatti&colon; <strong>".$responseR->NumeroTelefono." ".$responseR->Email."</strong></p>"."\n"
                        ."<p>Messsaggio&colon; <strong>".$responseR->Messaggio."</strong></p>"."\n";
            $requestI = (new funzioniAmministratore())->selectMessaggiInviati($responseR->IdMess);
            foreach($requestI as $responseI) {
                $messaggiAmm .= "<p>Risposta&colon;</p>"."\n".
                                "<p>Oggetto&colon; <strong>".$responseI->Oggetto."</strong></p>"."\n".
                                "<p>Messsaggio&colon; <strong>".$responseI->Messaggio."</strong></p>"."\n";
            }
            if(count($requestI) == 0) {
                $messaggiAmm .= "<form class=\"tastoModifiche\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"rispondi\" value=\"$responseR->IdMess\">RISPONDI</button>
                                </form>"."\n".
                                "<form class=\"tastoModifiche\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"eliminaMessaggio\" value=\"$responseR->IdMess\">ELIMINA MESSAGGIO</button>
                                </form>"."\n".
                            "</div>";
            } else {
                $messaggiAmm .= "<form class=\"tastoModifiche\" action=\"../PAGES/rispostaMessaggioAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"rispondi\" value=\"$responseR->IdMess\">RISPONDI</button>
                                </form>"."\n".
                                "<form class=\"tastoModifiche\" action=\"../PHP/eliminaMessaggiAmministratore.php\" method=\"post\">
                                    <button type=\"submit\" name=\"eliminaConversazione\" value=\"$responseR->IdMess\">ELIMINA CONVERSAZIONE</button>
                                </form>"."\n"
                            ."</div>";
            }
        }
        if(count($requestR) == 0) {
            $messaggiAmm .= "<p class='msgAmm'>Al momento non ci sono messaggi ricevuti&period;</p>";
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
