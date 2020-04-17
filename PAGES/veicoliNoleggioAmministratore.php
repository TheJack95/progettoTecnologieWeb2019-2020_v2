<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $request = (new funzioniAmministratore())->selectVeicoliNoleggio();
        $veicoliN = "";

        foreach($request as $response) {
            $veicoliN .= "<ul>"
                        ."  <li>Targa&colon; <strong>".$response->Targa."</strong></li>"
                        ."  <li>Marca&colon; <strong>".$response->Marca."</strong></li>"
                        ."  <li>Modello&colon; <strong>".$response->Modello."</strong></li>"
                        ."  <li>Cilindrata&colon; <strong>".$response->Cilindrata."</strong></li>"
                        ."  <li>Costo Noleggio&colon; <strong>".$response->CostoNoleggio."</strong></li>"
                        ."  <li>Cauzione&colon; <strong>".$response->Cauzione."</strong></li>"
                        ."  <li>Immagine&colon; <strong>".$response->Immagine."</strong></li>"
                        ."  <li>DescrImmagine&colon; <strong>".$response->DescrImmagine."</strong></li>"
                        ."</ul>"
                        ."  <form class=\"tastoModifiche\" action=\"../PAGES/modificaVeicoloNoleggio.php\" method=\"post\">
                                <button type=\"submit\" name=\"modifica\" value=\"$response->Targa\">MODIFICA</button>
                            </form>"
                        ."  <form class=\"tastoModifiche\" action=\"../PAGES/eliminaVeicoloNoleggio.php\" method=\"post\">
                                <button type=\"submit\" name=\"ELIMINAa\" value=\"$response->Targa\">ELIMINA</button>
                            </form>";
        }
        if(count($request) == 0) {
            $veicoliN .= "<p class=\"msgAmm\">Al momento non sono disponibili le informazioni richieste&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $output = file_get_contents("../HTML/veicoliNoleggioAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; VEICOLI A NOLEGGIO"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $output = str_replace("<veicoliNoleggio></veicoliNoleggio>",$veicoliN,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a>','<strong>VEICOLI A NOLEGGIO</strong>',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
