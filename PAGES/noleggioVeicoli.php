<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniVeicoli.php";

$output = file_get_contents("../HTML/noleggioAcquista.html");

$output = str_replace("<header></header>",funzioniGenerali::header(),$output);

$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Veicoli a noleggio"),$output);

$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

$rows = (new funzioniVeicoli())->getVeicoliNoleggio();
$veicoli = "";

foreach($rows as $row) {

	$veicoli .= '<div class="containerVeicolo">'."\n"
				.'	<img class="fotoVeicolo" src="'.$row->Immagine.'" alt="'.$row->DescrImmagine.'"/>'."\n"
				.'	<div class="datiVeicolo">'
				.'		<h2 class="titoloVeicolo">'.$row->Marca." ".$row->Modello.'</h2>'."\n"
				.'		<ul>'
				.'			<li>'
				.'				<p><strong>Cilindrata:</strong>  '.$row->Cilindrata.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Costo noleggio:</strong>'.$row->CostoNoleggio.' &#8364;</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Cauzione:</strong>'.$row->Cauzione.' &#8364;</p>'
				.'			</li>'
				.'		</ul>'
				.'		<a href="noleggioVeicolo.php?targaAuto='.$row->Targa.'" class="linkMod">Noleggia auto</a>'."\n"
				.'	</div>'."\n"
				.'</div>';
}

if(count($rows) == 0) {
	$veicoli = '<p> Nessun veicolo disponibile. </p>'; 
}

$output = str_replace("<auto></auto>",$veicoli,$output);

$filtri ='<div>'."\n"
		.'	<form action="noleggioVeicoli.php" method="post">'."\n"
		.'  	<fieldset>'."\n"
		.'				<label for="searchbar">Cerca veicoli</label>'."\n"
		.'				<input type="text" name="searchbar" tabindex="7" id="searchbar" />'."\n"
		.'				<p>Filtra per data disponibilit&agrave; (formato gg-mm-aaaa)</p>'."\n"
		.'				<label for="datainizio">Dal</label>'."\n"
		.'				<input type="text" name="datainizio" tabindex="8" id="datainizio" class="dataInput" />'."\n"
		.'				<label for="datafine">Al</label>'."\n"
		.'				<input type="text" name="datafine" tabindex="9" id="datafine" class="dataInput" />'."\n"
		.'				<input type="submit" name="applicaFiltri" value="Cerca" tabindex="10" />'."\n"
		.'				<input type="submit" name="ricaricapagina" value="Ricarica pagina" tabindex="11" />'."\n"
		.'  	</fieldset>'."\n"
		.'	</form>'."\n"
		.'</div>';

$output = str_replace("<filtriAuto></filtriAuto>",$filtri,$output);
$output = str_replace('<a href="noleggioVeicoli.php" tabindex="2">VEICOLI A NOLEGGIO</a>','<strong>VEICOLI A NOLEGGIO</strong>',$output);

echo $output;
?>