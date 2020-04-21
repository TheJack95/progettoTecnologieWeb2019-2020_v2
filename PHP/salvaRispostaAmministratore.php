<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $destinatario = $_SESSION["destinatario"];
        $oggetto = $_POST["oggetto"];
        $testo = $_POST["testo"];

        $connessioneDatabase = new database_connection;
        $insertRisposta = "INSERT INTO RisposteMessaggi() VALUES ('','$destinatario','$oggetto','$testo')";
        if ($connessioneDatabase->esegui($insertRisposta) == TRUE) {
            unset($_SESSION["destinatario"]);
            unset( $_POST["oggetto"]);
            unset($_POST["testo"]);
            $messaggio = "<p class='msgAmm msgSuccAmm'>Risposta al messaggio inviata correttamente</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/messaggiAmministratore.php");
        } else {
            unset( $_POST["oggetto"]);
            unset($_POST["testo"]);
            $messaggio = "<p class='msgAmm msgErrAmm'>Non &egrave; possibile inviare la risposta al messaggio per un problema del database&period; Riprova&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/rispostaMessaggioAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
