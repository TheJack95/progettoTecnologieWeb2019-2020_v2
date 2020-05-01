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
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la prenotazione del veicolo a noleggio per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/listaNoleggiAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
