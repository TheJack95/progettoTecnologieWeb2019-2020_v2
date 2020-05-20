<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $request = (new funzioniAmministratore())->selectNome();
        $nome = "";
        foreach($request as $response) {
            $nome .= " ".$response->Nome;
        }
        
        $output = file_get_contents("../HTML/homeAmministratore.html");
        $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
        $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
        $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Amministratore &#62;&#62; <span xml:lang='en' lang='en'>Homepage</span>"),$output);
        $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
        $output = str_replace("<nome></nome>",$nome,$output);
        $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
        $output = str_replace('<a href="homeAmministratore.php" tabindex="7">AREA AMMINISTRATORE</a>','<strong>AREA AMMINISTRATORE</strong>',$output);
        $output = str_replace('<a href="homeAmministratore.php" tabindex="10"><span xml:lang="en" lang="en">Home</span> amministratore</a>','&#62; <span xml:lang="en" lang="en">Home</span> amministratore',$output);
        echo $output;
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>