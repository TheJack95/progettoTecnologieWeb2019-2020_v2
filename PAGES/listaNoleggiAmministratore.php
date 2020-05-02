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
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Prenotazioni veicoli a noleggio"),$output);
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
                                    ."      <p class='pAmm'>Cliente&colon; ".$responseI->Nome." ".$responseI->Cognome." &lsqb;".$responseP->Utente."&rsqb;</p>"."\n"
                                    ."      <p class='pAmm'>Veicolo&colon; ".$responseA->Marca." ".$responseA->Modello." - ".$responseP->Targa."</p>"."\n"
                                    ."      <p class='pAmm'>Noleggio dal ".$inizio." al ".$fine."</p>"."\n"
                                    ."      <form class='formModAmm' action='../PHP/eliminaPrenotazioneAmministratore.php' method='post'>"."\n"
                                    ."          <fieldset>"."\n"
                                    ."              <legend></legend>"."\n"
                                    ."              <button type='submit' name='eliminaPrenotazione' class='noButt linkMod' value='$responseP->IdPrenot'>ELIMINA PRENOTAZIONE</button>"."\n"
                                    ."          </fieldset>"."\n"
                                    ."      </form>"."\n"
                                    ."  </div>"."\n"
                                    ."</div>";
                }
            }
        }
        if(count($requestP) == 0) {
            $listaNoleggi .= "<p class=\"msgAmm\">Al momento non ci sono prenotazioni per i veicoli a noleggio</p>";
        }
        $output = str_replace("<listaNoleggi></listaNoleggi>",$listaNoleggi,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="listaNoleggiAmministratore.php" tabindex="11">PRENOTAZIONI NOLEGGIO</a>','&gt; PRENOTAZIONI NOLEGGIO',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
