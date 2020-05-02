<?php
    require_once "../PHP/connessioneDB.php";
    require_once "../PHP/funzioniAmministratore.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $targa = $_POST["elimina"];
        $table = "noleggio";

        $request = (new funzioniAmministratore())->selectImmagine($targa, $table);
        $path = "";
        foreach($request as $response) {
            $path .= $response->Immagine;
        }
        unlink($path);

        $connessioneDatabase = new database_connection;
        $delete = "DELETE FROM AutoNoleggio WHERE Targa='$targa'";
        if ($connessioneDatabase->esegui($delete) == TRUE) {
            $messaggio = "<p class='messaggio successMessage'>Veicolo a noleggio eliminato correttamente</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        } else {
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare il veicolo a noleggio per un problema del database. Riprova</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
