<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $request = (new funzioniAmministratore())->selectVeicoliVendita();
        $veicoliV = "";
        foreach($request as $response) {
            $veicoliV .= "<div class='divAmm'>"."\n"
                        ."  <img class='imgAutoAmm' src='$response->Immagine' alt='$response->DescrImmagine' />"."\n"
                        ."  <div class='datiAutoAmm'>"."\n"
                        ."      <p class='pAmm'>".$response->Marca." ".$response->Modello."</p>"."\n"
                        ."      <p class='pAmm'>".$response->Cilindrata." cm&#179; &#8722; ".$response->KM." km</p>"."\n"
                        ."      <p class='pAmm'>Costo&#58; &#8364; ".$response->PrezzoVendita." &#43; i&#46;v&#46;a&#46;</p>"."\n"
                        ."      <form class='formRispAmm' action='../PAGES/modificaVeicoloVendita.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='modifica' class='noButt linkMod' value='$response->IdAuto'>Modifica veicolo</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."      <form class='formElimAmm' action='../PHP/eliminaVeicoloVendita.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='elimina' class='noButt linkMod' value='$response->IdAuto'>Elimina veicolo</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."  </div>"."\n"
                        ."</div>"."\n";
        }
        if(count($request) == 0) {
            $veicoliV .= "<p class='msgAmm'>Al momento non sono disponibili veicoli in vendita&#46;</p>";
        }
        
        $output = file_get_contents("../HTML/veicoliVenditaAmministratore.html");
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; Veicoli in vendita"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $output = str_replace("<veicoliVendita></veicoliVendita>",$veicoliV,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliVenditaAmministratore.php" tabindex="12">Veicoli in vendita</a>','&#62; Veicoli in vendita',$output);
        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>