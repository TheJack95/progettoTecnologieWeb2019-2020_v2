<?php

require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/funzioniUtente.php";



$output = file_get_contents("../HTML/areaPrivata.html");
$output = str_replace("<header></header>",funzioniGenerali::header(),$output);
$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

if(isset($_SESSION["errorMessage"])) {

    $errorMessage = $_SESSION["errorMessage"];
    $output = str_replace("<tagErrore></tagErrore>",$errorMessage,$output);
    unset($_SESSION["errorMessage"]);

} elseif(isset($_SESSION["successMessage"])) {

    $errorMessage = $_SESSION["successMessage"];
    $output = str_replace("<tagErrore></tagErrore>",$errorMessage,$output);
    unset($_SESSION["successMessage"]);

} else {

    $output = str_replace("<tagErrore></tagErrore>","<p></p>",$output);
}

if(isset($_SESSION["user"])) {

	$contentItems = "";
	$sideNav = "";
	$breadcrumb = "";

	$utente = $_SESSION["utente"];

	$sideNav = "<div id='nav'>"."\n"
				."	<h3 class='titoloMenu'>Menu Utente</h3>"."\n"
				."	<ul class='listaMenu'>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=principale' tabindex='9'>Area Personale</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=datiPersonali' tabindex='10'>Dati Personali</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=preventivi' tabindex='11'>Preventivi</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=noleggi' tabindex='12'>Noleggi</a></li>"."\n"
				."	   <li><a href='areaPrivata.php?pageName=messaggi' tabindex='13'>Messaggi</a></li>"."\n"
				."	</ul>"."\n"
				."</div>"."\n";

	$contentItems = "<div id='content'>"."\n"
				."	<h3 class='titolo'>Azioni rapide</h3>"."\n"
				."	<p>Benvenuto $utente! Scegli cosa fare dalle azioni rapide o naviga con il menu a sinistra!</p>"."\n"
				."	<a class='azioniRapide' href='areaPrivata.php?pageName=messaggi' tabindex='14'>Controlla i Messaggi</a>"."\n"
				."	<a class='azioniRapide' href='acquistaVeicoli.php' tabindex='15'>Guarda le nostre offerte</a>"."\n"
				."	<a class='azioniRapide' href='contatti.php#formMessaggio' tabindex='16'>Contatta l'Amministratore</a>"."\n"
				."</div>"."\n";


	if(isset($_GET["pageName"])) {

		$pageName = $_GET["pageName"];
		$Profilo= new funzioniUtente();

		switch($pageName) {
			case "principale":
				$breadcrumb = "";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=principale' tabindex='9'>Area Personale</a>",' &#62; Area Personale',$sideNav);
				break;
			case "preventivi":
				$breadcrumb = " &gt;&gt; Veicoli acquistati";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=preventivi' tabindex='11'>Preventivi</a>",' &#62; Preventivi',$sideNav);
				$contentItems = "<div id='content'>"."\n"
									.$Profilo->getPreventivi()
								."</div>"."\n";
				break;
			case "noleggi":
				$breadcrumb = " &gt;&gt; Veicoli noleggiati";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=noleggi' tabindex='12'>Noleggi</a>",' &#62; Noleggi',$sideNav);
				$contentItems = "<div id='content'>"."\n"
								.$Profilo->getNoleggi()
								."</div>"."\n";
				break;
			case "messaggi":
				$contentItems = "<div id='content'>"."\n".$Profilo->getMessaggi()."\n"."</div>"."\n";
				$breadcrumb = " &gt;&gt; Messaggi";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=messaggi' tabindex='13'>Messaggi</a>",' &#62; Messaggi',$sideNav);
				break;
			case "datiPersonali":
				$contentItems = "<div id='content'>"."\n".$Profilo->getDati()."\n"."</div>"."\n";
				$breadcrumb = " &gt;&gt; I tuoi dati";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=datiPersonali' tabindex='10'>Dati Personali</a>",' &#62; Dati Personali',$sideNav);
				break;
			case "setDatiPersonali":
				$contentItems = "<div id='content'>"."\n".$Profilo->setDati()."\n"."</div>"."\n";
				$breadcrumb = " &gt;&gt; Modifica i tuoi dati";
				$sideNav = str_replace("<a href='areaPrivata.php?pageName=datiPersonali' tabindex='10'>Dati Personali</a>",' &#62; Dati Personali',$sideNav);
				break;
			default:
				$breadcrumb = "";
				break;
		}
	} else {
			$breadcrumb = "";
			$sideNav = str_replace("<a href='areaPrivata.php?pageName=principale' tabindex='9'>Area Personale</a>",' &#62; Area Personale',$sideNav);
	}

	$output = str_replace("<sideNav></sideNav>",$sideNav, $output);
	$output = str_replace("<contentItems></contentItems>",$contentItems, $output);
	$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale$breadcrumb"),$output);
	$output = str_replace('<a href="areaPrivata.php" tabindex="7">AREA PERSONALE</a>','<strong>AREA PERSONALE</strong>',$output);

	echo $output;
} else {
	$errmessage = "Attenzione: non hai effettuato il login. Verrai reindirizzato alla pagina di login.";
	$_SESSION["errmessage"] = $errmessage;
}

?>