<?php

try {

	if(!isset($_SESSION))
		session_start();

	unset($_SESSION["user"]);
	unset($_SESSION["admin"]);
	unset($_SESSION["utente"]);

	$_SESSION["successmessage"] = "Logout effettuato con successo.";

} catch (Exception $e) {
	$_SESSION["errmessage"] = "Errore, ".$e->getMessage()."Riprova ad effettuare il logout, se il problema presiste contatta l&apos;amministratore.";
}

if(!isset($_SESSION["user"])) {
	header("location: ../PAGES/login.php");
} else {
	header("location: ../PAGES/areaPrivata.php");
}

?>
