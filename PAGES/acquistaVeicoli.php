<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniVeicoli.php";

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
                .'	    <ul>'
                .'          <li>'
				.'				<p><strong>Cilindrata:</strong> '.$row->Cilindrata.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>KM:</strong> '.$row->KM.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Prezzo di vendita:</strong> '.$row->PrezzoVendita.'</p>'
				.'			</li>'
				.'		</ul>'
                .'	</div>'."\n"
				.'	<a href="noleggioVeicolo.php?targaAuto='.$row->IdAuto.'">Richiedi preventivo</a>'."\n"
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

