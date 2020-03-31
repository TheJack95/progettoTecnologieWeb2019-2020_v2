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

	$veicoli .= '<div>'."\n"
				//."	<img class='' src='".$row->Immagine."' alt='".$row->DescrizioneImmagine."'/>"."\n"
				.'	<div>'
				.'		<h2>'.$row->Marca." ".$row->Modello.'</h2>'."\n"
				.'		<ul>'
				.'			<li>'
				.'				<p><strong>Cilindrata:</strong>  '.$row->Cilindrata.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Costo noleggio:</strong>'.$row->CostoNoleggio.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Cauzione:</strong>'.$row->Cauzione.'</p>'
				.'			</li>'
				.'		</ul>'
				.'	</div>'."\n"
				.'	<a href="noleggioVeicolo.php?targaAuto='.$row->Targa.'">Noleggia auto</a>'."\n"
				.'</div>';
}

$output = str_replace("<auto></auto>",$veicoli,$output);

$filtri ='<div>'."\n"
		.'	<form action="noleggioVeicoli.php" method="POST">'."\n"
		.'  	<fieldset>'."\n"
		.'				<label>Ricerca auto</label>'."\n"
		.'				<input type="text" name="searchbar" placeholder="Cerca..." tabindex="1">'."\n"
		.'				<p>Filtra per data disponibilita</p>'."\n"
		.'				<label>Dal</label>'."\n"
		.'				<input type="date" name="dataInizio" tabindex="2">'."\n"
		.'				<label>Al</label>'."\n"
		.'				<input type="date" name="dataFine" tabindex="3">'."\n"
		.'				<button type="submit" name="applicaFiltri" value="applicaFiltri" class="button internal-button" tabindex="4">Cerca</button>'."\n"
		.'  	</fieldset>'."\n"
		.'	</form>'."\n"
		.'</div>';

$output = str_replace("<filtriAuto></filtriAuto>",$filtri,$output);
$output = str_replace('<a href="noleggioVeicoli.php">VEICOLI A NOLEGGIO</a>','<strong>VEICOLI A NOLEGGIO</strong>',$output);

echo $output;
?>