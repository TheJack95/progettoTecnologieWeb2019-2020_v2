<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $marca = $_POST["marca"];
        $modello = $_POST["modello"];
        $km = $_POST["km"];
        $cilindrata = $_POST["cilindrata"];
        $prezzo = $_POST["prezzo"];
        $immagine = "";
        $descrizione = $_POST["descrizione"];
        if(is_uploaded_file($_FILES["immagineAuto"]["tmp_name"])) {
			$path = "../Images/".basename($_FILES["immagineAuto"]["name"]);
			if(move_uploaded_file($_FILES['immagineAuto']["tmp_name"], $path)) {
				$immagine = "../Images/".basename($_FILES["immagineAuto"]["name"]);
			}
		}

        $connessioneDatabase = new database_connection;
        $insert = "INSERT INTO AutoVendita() VALUES ('','$marca','$modello','$km','$cilindrata','$prezzo','$immagine','$descrizione')";
        if ($connessioneDatabase->esegui($insert) == TRUE) {
            unset($_POST["marca"]);
            unset($_POST["modello"]);
            unset($_POST["km"]);
            unset($_POST["cilindrata"]);
            unset($_POST["prezzo"]);
            unset($_FILES["immagineAuto"]["tmp_name"]);
            unset($_POST["descrizione"]);
            $messaggio = "<p class='messaggio successMessage'>Nuovo veicolo in vendita inserito correttamente&period; Potresti non vedere subito il veicolo appena inserito&comma; eventualmente ricarica la pagina&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliVenditaAmministratore.php");
        } else {
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inserire il nuovo veicolo in vendita per un problema del database&period; Riprova&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/nuovoVeicoloVendita.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
