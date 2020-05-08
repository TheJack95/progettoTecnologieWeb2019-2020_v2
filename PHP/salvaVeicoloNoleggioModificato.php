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
            $messaggio = "<p class='messaggio successMessage'>Informazioni sul veicolo a noleggio aggiornate correttamente&</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
        } else {
            $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni del veicolo a noleggio per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
            $_SESSION["nuovoMessaggio"] = $messaggio;
            header("location: ../PAGES/modificaVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
