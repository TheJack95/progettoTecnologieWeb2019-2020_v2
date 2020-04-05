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
            $veicoliV .= "<ul>"
                        ."  <li>Marca&colon; <strong>".$response->Marca."</strong></li>"
                        ."  <li>Modello&colon; <strong>".$response->Modello."</strong></li>"
                        ."  <li>KM&colon; <strong>".$response->KM."</strong></li>"
                        ."  <li>Cilindrata&colon; <strong>".$response->Cilindrata."</strong></li>"
                        ."  <li>Prezzo&colon; <strong>".$response->PrezzoVendita."</strong></li>"
                        ."  <li>Immagine&colon; <strong>".$response->Immagine."</strong></li>"
                        ."  <li>DescrImmagine&colon; <strong>".$response->DescrImmagine."</strong></li>"
                        ."</ul>";
        }
        if(count($request) == 0) {
            $veicoliV .= "<p class=\"\">Al momento non sono disponibili le informazioni richieste&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $output = file_get_contents("../HTML/veicoliVenditaAmministratore.html");
        
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Veicoli in vendita"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        $output = str_replace("<veicoliVendita></veicoliVendita>",$veicoliV,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        
        $output = str_replace('<a class="" href="areaPrivata.php">AREA PERSONALE</a>','<a href="homeAmministratore.php">AREA PERSONALE</a>',$output);
        $output = str_replace('<a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>VEICOLI IN VENDITA</strong>',$output);

        echo $output;
    } else {
        $message = "Attenzione&colon; non hai i permessi per accedere all&apos;area personale e sei stato reindirizzato alla pagina per accedere&excl;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
