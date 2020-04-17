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
	if(isset($_POST['richiedipreventivo'])) {
		$conn = new funzioniVeicoli();
		$auto = $conn->getVeicoloAcquista($_POST['richiedipreventivo'], false);
		$utente  = $_SESSION['user'];
		$idAuto  = $auto->idAuto;
		$prezzoVendita = intval($auto->PrezzoVendita);

		$response = $conn->richiediPreventivo($utente, $idAuto, $prezzoVendita);

	} else {
		$response->response = 'Errore imprevisto, riprovare. Se il problema persiste contatta l&apos;amministratore.';
		$response->status = false;
	}

	$output = funzioniGenerali::setMessaggio($response->response.'<a href="../PAGES/home.php"> Torna alla home</a>',!$response->status);
	$output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);
	
	echo $output;
} else {
	echo str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$logged->message);
}
?>