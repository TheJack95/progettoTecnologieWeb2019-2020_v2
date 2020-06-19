<?php 

require_once "../PHP/funzioniVeicoli.php";
require_once "../PHP/funzioniGenerali.php";


$logged = funzioniGenerali::checkSession();

if(!isset($_SESSION))
	session_start();
	
if($logged->status) {
	$response = (Object) [
		"status" => false
		,"response" => ""
	];

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_GET['idAuto'])) {
		$conn = new funzioniVeicoli();
		$auto = $conn->getVeicoloAcquista($_GET['idAuto'], false);
		$utente  = $_SESSION['user'];
		$prezzoVendita = intval($auto->PrezzoVendita);

		$response = $conn->richiediPreventivo($utente, $_GET['idAuto'], $prezzoVendita);
		$response->response .= $response->status ? "per l&apos;auto $auto->Marca $auto->Modello." : ".";
	} else {
		$response->response = 'Errore imprevisto, riprovare. Se il problema persiste contatta l&apos;amministratore.';
	}

	//$output = funzioniGenerali::setMessaggio($response->response.' <a href="../PAGES/home.php">Torna alla home</a>',!$response->status);
	//$output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);
	$class  = $response->status ? "successMessage" : "errorMessage";
	$_SESSION["messaggioAcquisto"] = "<p class='$class messaggio'>$response->response</p>";
	header("location: ../PAGES/acquistaVeicoli.php");
} else {
	echo str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$logged->message);
}
?>