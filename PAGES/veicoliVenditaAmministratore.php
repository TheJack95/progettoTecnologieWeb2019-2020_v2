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
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $request = (new funzioniAmministratore())->selectVeicoliVendita();
        $veicoliV = "";
        foreach($request as $response) {
            $veicoliV .= "<div class='divAmm'>"."\n"
                        ."  <img class='imgAutoAmm' src='$response->Immagine' alt='$response->DescrImmagine' />"."\n"
                        ."  <div class='datiAutoAmm'>"."\n"
                        ."      <p class='pAmm'><strong>".$response->Marca." ".$response->Modello."</strong></p>"."\n"
                        ."      <p class='pAmm'>".$response->Cilindrata." cm&sup3; - ".$response->KM." km</p>"."\n"
                        ."      <p class='pAmm'>costo&colon; &euro; ".$response->PrezzoVendita."</p>"."\n"
                        ."  </div>"."\n"
                        ."  <form class=\"formRispAmm\" action=\"../PAGES/modificaVeicoloVendita.php\" method=\"post\">"."\n"
                        ."       <button type=\"submit\" name=\"modifica\" class=\"noButt linkMod\" value=\"$response->IdAuto\">MODIFICA</button>"."\n"
                        ."  </form>"."\n"
                        ."  <form class=\"formElimAmm\" action=\"../PHP/eliminaVeicoloVendita.php\" method=\"post\">"."\n"
                        ."       <button type=\"submit\" name=\"elimina\" class=\"noButt linkMod\" value=\"$response->IdAuto\">ELIMINA</button>"."\n"
                        ."  </form>"."\n"
                        ."</div>"."\n";
        }
        if(count($request) == 0) {
            $veicoliV .= "<p class=\"msgAmm\">Al momento non sono disponibili veicoli in vendita&period;</p>";
        }
        $output = str_replace("<veicoliVendita></veicoliVendita>",$veicoliV,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliVenditaAmministratore.php" tabindex="11">VEICOLI IN VENDITA</a>','<strong>VEICOLI IN VENDITA</strong>',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
