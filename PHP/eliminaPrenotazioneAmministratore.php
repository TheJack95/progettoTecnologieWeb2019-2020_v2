<?php
    require_once "../PHP/connessioneDB.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $id = $_POST["eliminaPrenotazione"];

        $connessioneDatabase = new database_connection;
        $delete = "DELETE FROM PrenotazioneNoleggio WHERE IdPrenot='$id'";
        if ($connessioneDatabase->esegui($delete) == TRUE) {
            $messaggio = "<p class='messaggio successMessage'>Prenotazione del veicolo a noleggio eliminata correttamente</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/listaNoleggiAmministratore.php");
        } else {
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la prenotazione del veicolo a noleggio per un problema del database. Riprova</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/listaNoleggiAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
