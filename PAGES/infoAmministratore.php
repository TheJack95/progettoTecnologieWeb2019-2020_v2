<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $request = (new funzioniAmministratore())->selectInfoPersonali($_SESSION["user"]);
        $informazioni = "";
        foreach($request as $response) {
            if(!empty($response->DataNascita)) {
                $nascita = date('d/m/Y',strtotime($response->DataNascita));
            } else {
                $nascita = "";
            }
            $informazioni .= "<div class='divAmm'>"."\n"
                            ."  <p class='pAmm'>Nome completo&#58; ".$response->Nome." ".$response->Cognome."</p>"."\n"
                            ."  <p class='pAmm'>Data di nascita&#58; ".$nascita."</p>"."\n"
                            ."  <p class='pAmm'>Indirizzo&#58; ".$response->Indirizzo."</p>"."\n"
                            ."  <p class='pAmm'>Recapito telefonico&#58; ".$response->Telefono."</p>"."\n"
                            ."  <p class='pAmm'>Email&#58; ".$response->Email."</p>"."\n"
                            ."</div>";
        }
        if(count($request) == 0) {
            $informazioni .= "<p class='msgAmm'>Al momento non sono disponibili le informazioni personali richieste&#44; riprova pi&ugrave; tardi&#46;</p>";
        }

        $output = file_get_contents("../HTML/infoAmministratore.html");
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; Informazioni personali"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        if(isset($_SESSION["nuovoMessaggio"])){
            $output = str_replace("<messaggio></messaggio>",$_SESSION["nuovoMessaggio"],$output);
            unset($_SESSION["nuovoMessaggio"]);
        } else {
            $output = str_replace("<messaggio></messaggio>","",$output);
        }
        $output = str_replace("<infoPersonali></infoPersonali>",$informazioni,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a href="homeAmministratore.php" tabindex="5">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="infoAmministratore.php" tabindex="8">Informazioni personali</a>','&#62; Informazioni personali',$output);
        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>