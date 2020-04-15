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
            $informazioni .= "<p>Nome&colon; <strong>".$response->Nome."</strong></p>"."\n"
                            ."<p>Cognome&colon; <strong>".$response->Cognome."</strong></p>"."\n"
                            ."<p>Data di nascita&colon; <strong>".$response->DataNascita."</strong></p>"."\n"
                            ."<p>Indirizzo&colon; <strong>".$response->Indirizzo."</strong></p>"."\n"
                            ."<p>Telefono&colon; <strong>".$response->Telefono."</strong></p>"."\n"
                            ."<p>Email&colon; <strong>".$response->Email."</strong></p>"."\n";
        }
        if(count($request) == 0) {
            $informazioni .= "<p class=\"msgAmm\">Al momento non sono disponibili le informazioni richieste&comma; riprova pi&ugrave; tardi&period;</p>";
        }

        $output = file_get_contents("../HTML/infoAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; INFORMAZIONI PERSONALI"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>"," ",$output);
        }
        $output = str_replace("<infoPersonali></infoPersonali>",$informazioni,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a>','<strong>INFORMAZIONI PERSONALI</strong>',$output);

        echo $output;
    } else {
        $message = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore<br />e sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $message;
        header("location: ../PAGES/login.php");
    }
?>
