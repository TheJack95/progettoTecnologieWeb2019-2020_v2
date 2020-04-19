<?php

require_once "../PHP/controlloInput.php";
require_once "../PHP/connessioneDB.php";

try {

  if(!isset($_SESSION))
      session_start();

  $mail = $_POST["email"];
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $nascita = $_POST["nascita"];
  $pw = $_POST["password"];
  $pwRi = $_POST["ripetiPassword"];
  $cel = $_POST["numeroTelefono"];
  $indirizzo = $_POST["indirizzo"];
  $dbConnection = new database_connection();
  $messaggio = "";

	$query = 'SELECT Email FROM Utenti WHERE Email=\''.$mail.'\'';
  $queryResult = $dbConnection->esegui($query);

	if (!(mysqli_num_rows($queryResult)>0)) {
    if( controlloInput::validName($nome)
        && controlloInput::validName($cognome)
        && controlloInput::validEmail($mail)
        && controlloInput::validPhone($cel)
        && controlloInput::validPass($pw)
        && controlloInput::validPass($pwRi)
        && $pw === $pwRi ) {

          if(isset($nascita)) {
            $nascitaFormatted = controlloInput::FormatDate($nascita);
          } else {
      			$messaggio = "Non &egrave; possibile procedere alla registrazione perch&egrave; non sono presenti tutti i campi obbligatori.<br />Verifica di averli inseriti e riprova.";
            $_SESSION["errmessage"] = $messaggio;
      		}

          if(controlloInput::checkDateFormat($nascita)) {
						if(controlloInput::checkBirthdate($nascitaFormatted)) {
							$passHash = password_hash($pw, PASSWORD_DEFAULT);

							$queryInsert = "INSERT INTO Utenti (
										Email
										,Password
										,Nome
										,Cognome
										,Telefono
										,Indirizzo
										,DataNascita
										,FlAdmin
									) VALUES ('$mail','$passHash','$nome','$cognome','$cell','$indirizzo','$nascita','0')";

              $databaseConnection = new database_connection();

							if ($databaseConnection->esegui($queryInsert) === TRUE) {
                $messaggio = "Registrazione effettuata con successo. Puoi effettuare il login.";
                $_SESSION["successmessage"] = $messaggio;
							} else  {
                $messaggio = "Errore nella registrazione dei dati";
                $_SESSION["errmessage"] = $messaggio;
							}
						} else  {
							$messaggio = "Non &egrave; possibile procedere alla registrazione perch&egrave; devi essere maggiorenne per registrarti.";
              $_SESSION["errmessage"] = $messaggio;
            }
					} else {
						$messaggio = "Inserisci la data nel formato yyyy-mm-dd o dd-mm-yyyy, prestando attenzioni a usare i trattini";
            $_SESSION["errmessage"] = $messaggio;
          }
  		} else {
  			$messaggio = "Non &egrave; possibile procedere alla registrazione perch&egrave; non sono presenti tutti i campi obbligatori.<br />Verifica di averli inseriti e riprova.";
        $_SESSION["errmessage"] = $messaggio;
  		}
    } else {
      $messaggio = "Indirizzo e-mail inserito gi&agrave; utilizzato.";
      $_SESSION["errmessage"] = $messaggio;
    }
} catch (Exception $e) {
	echo $e->getMessage();
}

if(isset($_SESSION["successmessage"])) {
	header("location: ../PAGES/login.php");
} else {
	header("location: ../PAGES/registrati.php");
}

?>
