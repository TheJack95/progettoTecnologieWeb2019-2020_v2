<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $idAuto = $_SESSION["idAuto"];
        $marca = $_POST["marca"];
        $modello = $_POST["modello"];
        $km = $_POST["km"];
        $cilindrata = $_POST["cilindrata"];
        $prezzo = $_POST["prezzo"];

        $connessioneDatabase = new database_connection;
        $update = "UPDATE AutoVendita SET Marca='$marca', Modello='$modello', Km='$km', Cilindrata='$cilindrata', PrezzoVendita='$prezzo' WHERE IdAuto='$idAuto'";
        if ($connessioneDatabase->esegui($update) == TRUE) {
            $messaggio = "<p class='msgAmm'>Informazioni sul veicolo in vendita aggiornate correttamente&period; Potresti non vedere subito le modifiche appena inserite&comma; eventualmente ricarica la pagina&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliVenditaAmministratore.php");
        } else {
            $messaggio = "<p class='msgErrAmm'>ATTENZIONE&excl; Non &egrave; possibile modificare le informazioni del veicolo in venduta per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/modificaVeicoloVendita.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
