<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniVeicoli.php";

$output = file_get_contents("../HTML/noleggioVeicolo.html");

$output = str_replace("<header></header>",funzioniGenerali::header(),$output);

$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Noleggio del veicolo"),$output);

$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

$veicolo = (new funzioniVeicoli())->getAuto($_GET["targaAuto"]);

//$output = str_replace("__IMMAGINE__",$veicolo->Immagine,$output);
//$output = str_replace("_DESCRAUTO_",$veicolo->DescrImmagine,$output);
$output = str_replace("_TARGA_",$veicolo->Targa,$output);
$output = str_replace("_MARCAMODELLO_",$veicolo->Marca." ".$veicolo->Modello,$output);
$output = str_replace("_CILINDRATA_",$veicolo->Cilindrata,$output);
$output = str_replace("_COSTONOLEGGIO_",$veicolo->CostoNoleggio,$output);
$output = str_replace("_CAUZIONE_",$veicolo->Cauzione,$output);

echo $output;

?>