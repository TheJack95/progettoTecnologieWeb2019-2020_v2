<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $targa = $_SESSION["targa"];
        $marca = $_POST["marca"];
        $modello = $_POST["modello"];
        $cilindrata = $_POST["cilindrata"];
        $costo = $_POST["costo"];
        $cauzione = $_POST["cauzione"];

        $connessioneDatabase = new database_connection;
        $update = "UPDATE AutoNoleggio SET Marca='$marca', Modello='$modello', Cilindrata='$cilindrata', CostoNoleggio='$costo', Cauzione='$cauzione' WHERE Targa='$targa'";
        if ($connessioneDatabase->esegui($update) == TRUE) {
            $messaggio = "<p class='msgAmm'>Informazioni sul veicolo a noleggio aggiornate correttamente&period; Potresti non vedere subito le modifiche appena inserite&comma; eventualmente ricarica la pagina&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        } else {
            $messaggio = "<p class='msgErrAmm'>ATTENZIONE&excl; Non &egrave; possibile modificare le informazioni del veicolo a noleggio per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/modificaVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
