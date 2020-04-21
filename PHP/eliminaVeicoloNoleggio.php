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
            $messaggio = "<p class='msgAmm msgSuccAmm'>Veicolo a noleggio eliminato correttamente&period; Potresti vedere ancora il veicolo appena eliminato nella tua lista&comma; eventualmente ricarica la pagina&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        } else {
            $messaggio = "<p class='msgAmm msgErrAmm'>Non &egrave; possibile eliminare il veicolo a noleggio per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
