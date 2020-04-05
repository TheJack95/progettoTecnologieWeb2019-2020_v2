<?php

require_once "../PHP/connessioneDB.php";

try {

  if(!isset($_SESSION))
      session_start();

	$emailUtente = $_POST["mail"];
	$password = $_POST["password"];
  $dbConnection = new database_connection();
  $messaggio = "";

		if (isset($emailUtente)) {
			$query = 'SELECT Email, Password, FlAdmin, Nome, Cognome FROM Utenti WHERE Email=\''.$emailUtente.'\'';
      $queryResult = $dbConnection->esegui($query);

			if (mysqli_num_rows($queryResult)!=0) {
          $row=mysqli_fetch_assoc($queryResult);

					if (isset($password) && password_verify($password, $row['Password'])) {
						$_SESSION["admin"] = $row['FlAdmin'];
						$_SESSION["user"] = $row['Email'];
						$_SESSION["utente"] = $row['Nome']." ".$row['Cognome'];

					} else {
						$messaggio = "Email e/o password sbagliati.";
            $_SESSION["errmessage"] = $messaggio;
					}
				} else {
					$messaggio = "Non risulti registrato. Verifica di aver inserito i dati corretti o registrati.";
          $_SESSION["errmessage"] = $messaggio;
				}
		} else {
			$messaggio = "Errore durante il login.";
      $_SESSION["errmessage"] = $messaggio;
		}
} catch (Exception $e) {
	echo $e->getMessage();
}

if(isset($_SESSION["admin"]) && ($_SESSION["admin"] == 1)) {
	header("location: ../PAGES/homeAmministratore.php");
} elseif(isset($_SESSION["user"])) {
  header("location: ../PAGES/areaPrivata.php?pageName=principale");
} else {
  header("location: ../PAGES/login.php");
}

?>
