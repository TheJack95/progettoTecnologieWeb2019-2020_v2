<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniUtente.php";



$output = file_get_contents("../HTML/areaPrivata.html");
$output = str_replace("<header></header>",funzioniGenerali::header(),$output);
$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

if(isset($_SESSION["user"])) {

	$contentItems = "";
	$sideNav = "";
	$breadcrumb = "";

	$utente = $_SESSION["utente"];

	$sideNav = "<div id='nav'>"."\n"
				."	<h3 class='titoloMenu'>Menu Utente</h3>"."\n"
				."	<ul class='listaMenu'>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=principale' tabindex='7'>Area Personale</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=datiPersonali' tabindex='8'>Dati Personali</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=preventivi' tabindex='9'>Preventivi</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=noleggi' tabindex='10'>Noleggi</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=messaggi' tabindex='11'>Messaggi</a></li>"."\n"
				."	</ul>"."\n"
				."</div>"."\n";

	$contentItems = "<div id='content'>"."\n"
				."	<h3 class='titolo'>Azioni rapide</h3>"."\n"
				."	<p>Benvenuto $utente! Scegli cosa fare dalle azioni rapide o naviga con il menu a sinistra!</p>"."\n"
				."	<a class='azioniRapide' href='areaPrivata.php?pageName=messaggi' tabindex='12'>Controlla i Messaggi</a>"."\n"
				."	<a class='azioniRapide' href='acquistaVeicoli.php' tabindex='13'>Guarda le nostre offerte</a>"."\n"
				."	<a class='azioniRapide' href='contatti.php#formMessaggio' tabindex='14'>Contatta l'Amministratore</a>"."\n"
				."</div>"."\n";

	$output = str_replace("<sideNav></sideNav>",$sideNav, $output);

	if(isset($_GET["pageName"])) {

		$pageName = $_GET["pageName"];
		$Profilo= new funzioniUtente();

		switch($pageName) {
			case "principale":
				$breadcrumb = "";
				break;
			case "preventivi":
				$breadcrumb = " >> Veicoli acquistati";
				$contentItems = "<div id='content'>"."\n"
									.$Profilo->getPreventivi()
								."</div>"."\n";
				break;
			case "noleggi":
				$breadcrumb = " >> Veicoli noleggiati";
				$contentItems = "<div id='content'>"."\n"
								.$Profilo->getNoleggi()
								."</div>"."\n";
				break;
			case "messaggi":
				$contentItems = "<div id='content'>"."\n".$Profilo->getMessaggi()."\n"."</div>"."\n";
				$breadcrumb = " >> Messaggi";
				break;
			case "datiPersonali":
				$contentItems = "<div id='content'>"."\n".$Profilo->getDati()."\n"."</div>"."\n";
				$breadcrumb = " >> I tuoi dati";
				break;
			default:
				$breadcrumb = "";
				break;
		}
	}

	$output = str_replace("<contentItems></contentItems>",$contentItems, $output);
	$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale$breadcrumb"),$output);
	$output = str_replace('<a class="" href="areaPrivata.php" tabindex="5">AREA PERSONALE</a>','<strong>AREA PERSONALE</strong>',$output);

	echo $output;
} else {
	$errmessage = "Attenzione: non hai effettuato il login. Verrai reindirizzato alla pagina di login.";
	$_SESSION["errmessage"] = $errmessage;
}

?>
