<?php

try {

	if(!isset($_SESSION))
		session_start();

	unset($_SESSION["user"]);
	$_SESSION["successmessage"] = "Logout effettuato con successo.";

} catch (Exception $e) {
	$_SESSION["errmessage"] = "Errore, ".$e->getMessage()."Riprova ad effettuare il logout, se il problema presiste contatta l&apos;amministratore.";
}


header("Location: http://localhost/progettoTecnologieWeb2019-2020_v2/PAGES/login.php");

?>
