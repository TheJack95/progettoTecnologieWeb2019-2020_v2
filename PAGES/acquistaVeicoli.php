<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniVeicoli.php";

$output = file_get_contents("../HTML/noleggioAcquista.html");

$output = str_replace("<header></header>",funzioniGenerali::header(),$output);

$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Veicoli in vendita"),$output);

$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

$rows = (new funzioniVeicoli())->getVeicoliAcquista();
$veicoli = "";

foreach($rows as $row) {
	$veicoli .= '<div class="containerVeicolo">'."\n"
				.'	<img class="fotoVeicolo" src="'.$row->Immagine.'" alt="'.$row->DescrImmagine.'" />'."\n"
				.'	<div class="datiVeicolo">'."\n"
				.'		<h2 class="titoloVeicolo">'.$row->Marca. " " .$row->Modello.'</h2>'."\n"
                .'	    <ul>'
                .'          <li>'
				.'				<p><strong>Cilindrata:</strong> '.$row->Cilindrata.' cm&sup3; </p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>KM:</strong> '.$row->KM.'</p>'
				.'			</li>'
				.'			<li>'
				.'				<p><strong>Prezzo di vendita:</strong> '.$row->PrezzoVendita.' &#8364;</p>'
				.'			</li>'
				.'		</ul>'
				.'		<a class="linkMod hidePrint" href="../PHP/acquistaVeicoloFn.php?idAuto='.$row->IdAuto.'">Richiedi preventivo</a>'."\n"
				/*.'		<form class="preventivoForm hidePrint" action="../PHP/acquistaVeicoloFn.php" method="post">'."\n"
				.'			<fieldset>'."\n"
                .'				<button type="submit" name="richiedipreventivo" value="'.$row->IdAuto.'" class="button linkMod" >Richiedi preventivo</button>'."\n"
				.'			</fieldset>'."\n"
				.'		</form>'."\n"*/
                .'	</div>'."\n"
				.'</div>';
}

if(count($rows) == 0) {
	$veicoli = '<p> Nessun veicolo disponibile. </p>'; 
}

$output = str_replace("<auto></auto>",$veicoli,$output);

$filtri ='<form action="acquistaVeicoli.php" method="post">'."\n"
		.'	<fieldset>'."\n"
		.'  	<legend>Filtri di ricerca</legend>'."\n"
		.'		<label for="searchbar">Cerca veicoli</label>'."\n"
		.'		<input type="text" id="searchbar" name="searchbar" tabindex="9" />'."\n"
		.'		<input type="submit" name="applicafiltri" value="Cerca" tabindex="10" />'."\n"
		.'		<input type="submit" name="ricaricapagina" value="Ricarica pagina" tabindex="11" />'."\n"
		.'	</fieldset>'."\n"
		.'</form>';

$output = str_replace("<filtriAuto></filtriAuto>",$filtri,$output);
$output = str_replace('<a href="acquistaVeicoli.php" tabindex="5">VEICOLI IN VENDITA</a>','<strong>VEICOLI IN VENDITA</strong>',$output);

echo $output;

?>