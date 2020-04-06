<?php 

require_once "../PHP/funzioniVeicoli.php";
require_once "../PHP/funzioniGenerali.php";

$logged = funzioniGenerali::checkSession();
if($logged->status) {
	$response = (Object) [
		"status" => false
		,"response" => ""
	];

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_GET['idAuto']) && isset($_GET['prezzoVendita'])) {
		$auto = new funzioniVeicoli();
		$utente  = $_SESSION['user'];
		$idAuto  = $_GET['idAuto'];
		$prezzoVendita = intval($_GET['prezzoVendita']);

		$response = $auto->richiediPreventivo($utente, $idAuto, $prezzoVendita);

	} else {
		$response->response = 'Errore imprevisto, riprovare. Se il problema persiste contatta l&apos;amministratore.';
		$response->status = false;
	}

	$output = funzioniGenerali::setMessaggio($response->response,!$response->status);
	$output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);

	echo $output;
} else {
	echo $logged->message;
	header("refresh:5; url= ../PAGES/login.php");
}
?>