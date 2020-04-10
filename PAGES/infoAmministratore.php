<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $request = (new funzioniAmministratore())->selectInfoPersonali();
        $informazioni = "";

        foreach($request as $response) {
            $informazioni .= "<ul>"
                            ."  <li>Nome&colon; <strong>".$response->Nome."</strong></li>"
                            ."  <li>Cognome&colon; <strong>".$response->Cognome."</strong></li>"
                            ."  <li>Data di nascita&colon; <strong>".$response->DataNascita."</strong></li>"
                            ."  <li>Indirizzo&colon; <strong>".$response->Indirizzo."</strong></li>"
                            ."  <li>Telefono&colon; <strong>".$response->Telefono."</strong></li>"
                            ."  <li>Email&colon; <strong>".$response->Email."</strong></li>"
                            ."</ul>";
        }
        if(count($request) == 0) {
            $informazioni .= "<p class=\"\">Al momento non sono disponibili le informazioni richieste&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $output = file_get_contents("../HTML/infoAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Informazioni Personali"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        $output = str_replace("<infoPersonali></infoPersonali>",$informazioni,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>INFORMAZIONI PERSONALI</strong>',$output);

        echo $output;
    } else {
        $message = "Attenzione&colon; non hai i permessi per accedere all&apos;area personale e sei stato reindirizzato alla pagina per accedere&excl;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
