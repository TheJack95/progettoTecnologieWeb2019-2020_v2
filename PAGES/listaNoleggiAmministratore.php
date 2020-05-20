<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/listaNoleggiAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; Prenotazioni veicoli a noleggio"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $requestP = (new funzioniAmministratore())->selectPrenotazioniNoleggio();
        $listaNoleggi = "";
        foreach($requestP as $responseP) {
            $requestA = (new funzioniAmministratore())->selectAutoNoleggiata($responseP->Targa);
            foreach($requestA as $responseA) {
                $requestI = (new funzioniAmministratore())->selectInfoPersonali($responseP->Utente);
                foreach($requestI as $responseI) {
                    $inizio = date('d/m/Y',strtotime($responseP->InizioNoleggio));
                    $fine = date('d/m/Y',strtotime($responseP->FineNoleggio));
                    $listaNoleggi .= "<div class='divAmm'>"."\n"
                                    ."  <img class='imgAutoAmm' src='$responseA->Immagine' alt='$responseA->DescrImmagine' />"."\n"
                                    ."  <div class='datiAutoAmm'>"."\n"
                                    ."      <p class='pAmm'>Cliente&#58; ".$responseI->Nome." ".$responseI->Cognome." &#91;".$responseP->Utente."&#93;</p>"."\n"
                                    ."      <p class='pAmm'>Veicolo&#58; ".$responseA->Marca." ".$responseA->Modello." &#8722; ".$responseP->Targa."</p>"."\n"
                                    ."      <p class='pAmm'>Noleggio dal ".$inizio." al ".$fine."</p>"."\n"
                                    ."      <form class='formModAmm' action='../PHP/eliminaPrenotazioneAmministratore.php' method='post'>"."\n"
                                    ."          <fieldset>"."\n"
                                    ."              <legend>Elimina prenotazione</legend>"."\n"
                                    ."              <button type='submit' name='eliminaPrenotazione' class='noButt linkMod' value='$responseP->IdPrenot'>Elimina prenotazione</button>"."\n"
                                    ."          </fieldset>"."\n"
                                    ."      </form>"."\n"
                                    ."  </div>"."\n"
                                    ."</div>";
                }
            }
        }
        if(count($requestP) == 0) {
            $listaNoleggi .= "<p class=\"msgAmm\">Al momento non ci sono prenotazioni per i veicoli a noleggio&#46;</p>";
        }
        $output = str_replace("<listaNoleggi></listaNoleggi>",$listaNoleggi,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="listaNoleggiAmministratore.php" tabindex="11">Prenotazioni veicoli</a>','&#62; Prenotazioni veicoli',$output);

        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>