<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $targa = $_POST["targa"];
        $marca = $_POST["marca"];
        $modello = $_POST["modello"];
        $cilindrata = $_POST["cilindrata"];
        $costo = $_POST["costo"];
        $cauzione = $_POST["cauzione"];
        $immagine = "";
        $descrizione = $_POST["descrizione"];
        if(is_uploaded_file($_FILES["immagineAuto"]["tmp_name"])) {
			$path = "../Images/". basename($_FILES["immagineAuto"]["name"]);
			if(move_uploaded_file($_FILES['immagineAuto']["tmp_name"], $path)) {
				$immagine = "../Images/". basename($_FILES["immagineAuto"]["name"]);
			}
		}

        $connessioneDatabase = new database_connection;
        $insert = "INSERT INTO AutoNoleggio() VALUES ('$targa','$marca','$modello','$cilindrata','$costo','$cauzione','$immagine','$descrizione')";
        if ($connessioneDatabase->esegui($insert) == TRUE) {
            unset($_POST["targa"]);
            unset($_POST["marca"]);
            unset($_POST["modello"]);
            unset($_POST["cilindrata"]);
            unset($_POST["costo"]);
            unset($_POST["cauzione"]);
            unset($_FILES["immagine"]["tmp_name"]);
            unset($_POST["descrizione"]);
            $messaggio = "<p class='msgAmm'>Nuovo veicolo a noleggio inserito correttamente&period; Potresti non vedere subito il veicolo appena inserito&comma; eventualmente ricarica la pagina&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        } else {
            $messaggio = "<p class='msgErrAmm'>ATTENZIONE&excl; Non &egrave; possibile inserire il nuovo veicolo a noleggio per un problema del database&period; Riprova&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/nuovoVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
