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
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; Veicoli a noleggio"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $request = (new funzioniAmministratore())->selectVeicoliNoleggio();
        $veicoliN = "";
        foreach($request as $response) {
            $veicoliN .= "<div class='divAmm'>"."\n"
                        ."  <img class='imgAutoAmm' src='$response->Immagine' alt='$response->DescrImmagine' />"."\n"
                        ."  <div class='datiAutoAmm'>"."\n"
                        ."      <p class='pAmm'>".$response->Marca." ".$response->Modello." &#8722; ".$response->Targa."</p>"."\n"
                        ."      <p class='pAmm'>".$response->Cilindrata." cm&#179;</p>"."\n"
                        ."      <p class='pAmm'>Costo&#58; &#8364; ".$response->CostoNoleggio." al giorno &#43; cauzione &#8364; ".$response->Cauzione."</p>"."\n"
                        ."      <form class='formRispAmm' action='../PAGES/modificaVeicoloNoleggio.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='modifica' class='noButt linkMod' value='$response->Targa'>Modifica veicolo</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."      <form class='formElimAmm' action='../PHP/eliminaVeicoloNoleggio.php' method='post'>"."\n"
                        ."          <fieldset>"."\n"
                        ."              <button type='submit' name='elimina' class='noButt linkMod' value='$response->Targa'>Elimina veicolo</button>"."\n"
                        ."          </fieldset>"."\n"
                        ."      </form>"."\n"
                        ."  </div>"."\n"
                        ."</div>";
        }
        if(count($request) == 0) {
            $veicoliN .= "<p class='msgAmm'>Al momento non sono disponibili veicoli a nolegggio&#46;</p>";
        }
        $output = str_replace("<veicoliNoleggio></veicoliNoleggio>",$veicoliN,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliNoleggioAmministratore.php" tabindex="10">Veicoli a noleggio</a>','&#62; Veicoli a noleggio',$output);

        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
