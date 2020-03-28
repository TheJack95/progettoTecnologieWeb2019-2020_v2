<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniAuto.php";

$output = file_get_contents("../HTML/noleggioAcquista.html");

$output = str_replace("<header></header>",funzioniGenerali::header(),$output);

$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Veicoli in vendita"),$output);

$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

$rows = (new funzioniVeicoli())->getAutoAcquista();
$veicoli = "";

foreach($rows as $row) {

	$veicoli .= '<div>'."\n"
				//."	<img class='' src='".$row->Immagine."' alt='".$row->DescrizioneImmagine."'/>"."\n"
				.'	<div>'."\n"
				.'		<h2>'.$row->Marca. " " .$row->Modello.'</h2>'."\n"
				.'	</div>'."\n"
				.'	<div>'."\n"
				.'		<h4>Cilindrata</h4>'."\n"
				.'		<p>'.$row->Cilindrata.'</p>'."\n"
				.'	</div>'."\n"
				.'	<div>'."\n"
				.'		<h4>KM</h4>'."\n"
				.'		<p>'.$row->KM.'</p>'."\n"
				.'	</div>'."\n"
				.'	<div>'."\n"
				.'		<h4>Prezzo</h4>'."\n"
				.'		<p>'.$row->PrezzoVendita.'</p>'."\n"
				.'	</div>'."\n"
				.'	<form action="../PHP/" method="post">'."\n"
				.'		<div>'."\n"
				.'			<button type="submit" name="" value="'.$row->IdAuto.'" class="button internal-button">Richiedi Prevetivo</button>'."\n"
				.'		</div>'."\n"
				.'	</form>'."\n"
				.'</div>';
}

$output = str_replace("<auto></auto>",$veicoli,$output);

$filtri ='<div>'."\n"
		.'	<form action="acquistaVeicoli.php" method="POST">'."\n"
		.'  	<fieldset>'."\n"
		.'			<label>Ricerca auto</label>'."\n"
		.'				<input type="text" name="searchbar" placeholder="Cerca..." tabindex="1">'."\n"
		.'				<label>Solo Viecoli Disponibili</label>'."\n"
		.'				<input type="checkbox" name="veicoliDisponibili" value="true" tabindex="2">'."\n"
		.'				<button type="submit" name="applicaFiltri" value="applicaFiltri" class="button internal-button" tabindex="3">Cerca</button>'."\n"
		.'  	</fieldset>'."\n"
		.'	</form>'."\n"
		.'</div>';

$output = str_replace("<filtriAuto></filtriAuto>",$filtri,$output);
$output = str_replace('<a href="acquistaVeicoli.php">VEICOLI IN VENDITA</a>','<strong>VEICOLI IN VENDITA</strong>',$output);

echo $output;

?>

