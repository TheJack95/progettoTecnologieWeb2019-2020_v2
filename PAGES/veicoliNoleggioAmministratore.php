<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/veicoliNoleggioAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Veicoli a noleggio"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $request = (new funzioniAmministratore())->selectVeicoliNoleggio();
        $veicoliN = "";
        foreach($request as $response) {
            $veicoliN .= "<div class='divAmm'>"."\n"
                        ."  <img class='imgAutoAmm' src='$response->Immagine' alt='$response->DescrImmagine' />"."\n"
                        ."  <div class='datiAutoAmm'>"."\n"
                        ."      <p class='pAmm'><strong>".$response->Marca." ".$response->Modello."</strong> - ".$response->Targa."</p>"."\n"
                        ."      <p class='pAmm'>".$response->Cilindrata." cm&sup3;</p>"."\n"
                        ."      <p class='pAmm'>costo&colon; &euro; ".$response->CostoNoleggio." &plus; cauzione &euro; ".$response->Cauzione."</p>"."\n"
                        ."      <form class=\"formRispAmm\" action=\"../PAGES/modificaVeicoloNoleggio.php\" method=\"post\">"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type=\"submit\" name=\"modifica\" class=\"noButt linkMod\" value=\"$response->Targa\">MODIFICA</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."      <form class=\"formElimAmm\" action=\"../PHP/eliminaVeicoloNoleggio.php\" method=\"post\">"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type=\"submit\" name=\"elimina\" class=\"noButt linkMod\" value=\"$response->Targa\">ELIMINA</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."  </div>"."\n"
                        ."</div>";
        }
        if(count($request) == 0) {
            $veicoliN .= "<p class=\"msgAmm\">Al momento non sono disponibili veicoli a nolegggio&period;</p>";
        }
        $output = str_replace("<veicoliNoleggio></veicoliNoleggio>",$veicoliN,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliNoleggioAmministratore.php" tabindex="10">VEICOLI A NOLEGGIO</a>','<strong>VEICOLI A NOLEGGIO</strong>',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
