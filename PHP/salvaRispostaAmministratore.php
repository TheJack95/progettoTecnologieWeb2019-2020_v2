<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $errori = "";
        $valid = true;
        if(isset($_POST["oggetto"]) && !empty($_POST["oggetto"])) {
            $oggetto = htmlentities($_POST["oggetto"], ENT_QUOTES, "UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&apos;oggetto inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto&period;</p>";
        }
        if(isset($_POST["testo"]) && !empty($_POST["testo"])) {
            $testo = htmlentities($_POST["testo"], ENT_QUOTES, "UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il messaggio inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto&period;</p>";
        }
        if($valid == true) {
            $destinatario = $_SESSION["destinatario"];

            $connessioneDatabase = new database_connection;
            $insertRisposta = "INSERT INTO RisposteMessaggi() VALUES ('','$destinatario','$oggetto','$testo')";
            if ($connessioneDatabase->esegui($insertRisposta) == TRUE) {
                unset($_SESSION["destinatario"]);
                unset( $_POST["oggetto"]);
                unset($_POST["testo"]);
                $messaggio = "<p class='messaggio successMessage'>Risposta al messaggio inviata correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inviare la risposta al messaggio per un problema del database&period; Riprova&period;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/rispostaMessaggioAmministratore.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/rispostaMessaggioAmministratore.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
