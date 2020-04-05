<?php

try {

	if(!isset($_SESSION))
		session_start();

	unset($_SESSION["user"]);
	$_SESSION["successmessage"] = "Logout effettuato con successo.";

} catch (Exception $e) {
	$_SESSION["errmessage"] = "Errore, ".$e->getMessage()."Riprova ad effettuare il logout, se il problema presiste contatta l&apos;amministratore.";
}


header("refresh:2; url= ../PAGES/login.php");

?>
