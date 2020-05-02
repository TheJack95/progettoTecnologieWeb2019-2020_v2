<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $output = file_get_contents("../HTML/infoAmministratore.html");

        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &gt;&gt; Informazioni personali"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $request = (new funzioniAmministratore())->selectInfoPersonali($_SESSION["user"]);
        $informazioni = "";
        foreach($request as $response) {
            if(!empty($response->DataNascita)) {
                $nascita = date('d/m/Y',strtotime($response->DataNascita));
            } else {
                $nascita = "";
            }
            $informazioni .= "<div class='divAmm'>"."\n"
                            ."  <p class='pAmm'>Nome completo&colon; ".$response->Nome." ".$response->Cognome."</p>"."\n"
                            ."  <p class='pAmm'>Data di nascita&colon; ".$nascita."</p>"."\n"
                            ."  <p class='pAmm'>Indirizzo&colon; ".$response->Indirizzo."</p>"."\n"
                            ."  <p class='pAmm'>Recapito telefonico&colon; ".$response->Telefono."</p>"."\n"
                            ."  <p class='pAmm'>Email&colon; ".$response->Email."</p>"."\n"
                            ."</div>";
        }
        if(count($request) == 0) {
            $informazioni .= "<p class='msgAmm'>Al momento non sono disponibili le informazioni personali richieste, riprova pi&ugrave; tardi</p>";
        }
        $output = str_replace("<infoPersonali></infoPersonali>",$informazioni,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

        $output = str_replace('<a class="" href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="infoAmministratore.php" tabindex="8">INFORMAZIONI PERSONALI</a>','&gt;INFORMAZIONI PERSONALI',$output);

        echo $output;
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
