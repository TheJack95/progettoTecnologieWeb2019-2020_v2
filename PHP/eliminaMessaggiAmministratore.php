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
                $messaggio = "<p class='messaggio successMessage'>Messaggio eliminato correttamente&period; Potresti vedere ancora il messaggio appena eliminato nella tua lista&comma; eventualmente ricarica la pagina&period;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare il messaggio per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
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
                    $messaggio = "<p class='messaggio successMessage'>Conversazione eliminata correttamente&period; Potresti vedere ancora i messaggi appena eliminati nella tua lista&comma; eventualmente ricarica la pagina&period;</p>";
                    $_SESSION["nuovoMessaggio"] = $messaggio;
                    header("location: ../PAGES/messaggiAmministratore.php");
                } else {
                    $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la conversazione per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
                    $_SESSION["nuovoMessaggio"] = $messaggio;
                    header("location: ../PAGES/messaggiAmministratore.php");
                }
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile eliminare la conversazione per un problema del database&period; Riprova pi&ugrave; tardi&period;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            }
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
