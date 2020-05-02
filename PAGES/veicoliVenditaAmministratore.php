<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/veicoliVenditaAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Veicoli in vendita"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $request = (new funzioniAmministratore())->selectVeicoliVendita();
        $veicoliV = "";
        foreach($request as $response) {
            $veicoliV .= "<div class='divAmm'>"."\n"
                        ."  <img class='imgAutoAmm' src='$response->Immagine' alt='$response->DescrImmagine' />"."\n"
                        ."  <div class='datiAutoAmm'>"."\n"
                        ."      <p class='pAmm'>".$response->Marca." ".$response->Modello."</p>"."\n"
                        ."      <p class='pAmm'>".$response->Cilindrata." cm&sup3; - ".$response->KM." km</p>"."\n"
                        ."      <p class='pAmm'>Costo&colon; &euro; ".$response->PrezzoVendita." &plus; i.v.a.</p>"."\n"
                        ."      <form class='formRispAmm' action='../PAGES/modificaVeicoloVendita.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='modifica' class='noButt linkMod' value='$response->IdAuto'>MODIFICA VEICOLO</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."      <form class='formElimAmm' action='../PHP/eliminaVeicoloVendita.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='elimina' class='noButt linkMod' value='$response->IdAuto'>ELIMINA VEICOLO</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."  </div>"."\n"
                        ."</div>"."\n";
        }
        if(count($request) == 0) {
            $veicoliV .= "<p class='msgAmm'>Al momento non sono disponibili veicoli in vendita</p>";
        }
        $output = str_replace("<veicoliVendita></veicoliVendita>",$veicoliV,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliVenditaAmministratore.php" tabindex="12">VEICOLI IN VENDITA</a>','&gt; VEICOLI IN VENDITA',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
