<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniVeicoli.php";

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION['utente'])) {

    $output = file_get_contents("../HTML/noleggioVeicolo.html");

    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);

    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Noleggio del veicolo"),$output);

    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

    $veicolo = (new funzioniVeicoli())->getVeicoliNoleggio($_GET["targaAuto"]);
    
    //$output = str_replace("__IMMAGINE__",$veicolo->Immagine,$output);
    //$output = str_replace("_DESCRAUTO_",$veicolo->DescrImmagine,$output);
    $output = str_replace("_TARGA_",$veicolo->Targa,$output);
    $output = str_replace("_MARCAMODELLO_",$veicolo->Marca." ".$veicolo->Modello,$output);
    $output = str_replace("_CILINDRATA_",$veicolo->Cilindrata,$output);
    $output = str_replace("_COSTONOLEGGIO_",$veicolo->CostoNoleggio,$output);
    $output = str_replace("_CAUZIONE_",$veicolo->Cauzione,$output);

    echo $output;
} else {
    $messaggio = 'Devi effettuare l&apos;accesso prima di procedere con l&apos;operazione. Verrai reindirizzato alla pagina di login';

    $output = funzioniGenerali::setMessaggio($messaggio,false);
    $output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);

    echo $output;
    header("refresh:5; url= ../PAGES/login.php");
}





?>