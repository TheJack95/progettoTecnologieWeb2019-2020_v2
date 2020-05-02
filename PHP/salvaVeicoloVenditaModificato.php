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
            $messaggio = "<p class='messaggio successMessage'>Informazioni sul veicolo in vendita aggiornate correttamente</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliVenditaAmministratore.php");
        } else {
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni del veicolo in venduta per un problema del database. Riprova</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/modificaVeicoloVendita.php");
        }
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
