<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        if(isset($_POST["eliminaMessaggio"])) {
            $idMessaggio = $_POST["eliminaMessaggio"];

            $connessioneDatabase = new database_connection;
            $delete = "DELETE FROM Messaggi WHERE IdMess='$idMessaggio'";
            if ($connessioneDatabase->esegui($delete) == TRUE) {
                $messaggio = "<p class='messaggio successMessage'>Messaggio eliminato correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare il messaggio per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            }
        }
        if(isset($_POST["eliminaConversazione"])) {
            $idMessaggio = $_POST["eliminaConversazione"];

            $connessioneDatabase = new database_connection;
            $deleteR = "DELETE FROM RisposteMessaggi WHERE Destinatario='$idMessaggio'";
            if ($connessioneDatabase->esegui($deleteR) == TRUE) {
                $connessioneDatabase2 = new database_connection;
                $deleteM = "DELETE FROM Messaggi WHERE IdMess='$idMessaggio'";
                if ($connessioneDatabase2->esegui($deleteM) == TRUE) {
                    $messaggio = "<p class='messaggio successMessage'>Conversazione eliminata correttamente</p>";
                    $_SESSION["nuovoMessaggio"] = $messaggio;
                    header("location: ../PAGES/messaggiAmministratore.php");
                } else {
                    $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la conversazione per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                    $_SESSION["nuovoMessaggio"] = $messaggio;
                    header("location: ../PAGES/messaggiAmministratore.php");
                }
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la conversazione per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            }
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>