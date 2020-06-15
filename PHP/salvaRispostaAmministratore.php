<?php
    require_once "../PHP/controlloInput.php";
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $errori = "";
        $valid = true;

        $oggetto = htmlentities($_POST["oggetto"], ENT_QUOTES, "UTF-8");
        if(controlloInput::validTestoCorto($oggetto) == false) {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&#39;oggetto inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }
        
        $testo = htmlentities($_POST["messaggio"], ENT_QUOTES, "UTF-8");
        if(controlloInput::validTesto($testo) == false) {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il messaggio inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }
        
        if($valid == true) {
            $destinatario = $_SESSION["destinatario"];

            $connessioneDatabase = new database_connection;
            $insertRisposta = "INSERT INTO RisposteMessaggi() VALUES ('','$destinatario','$oggetto','$testo')";
            if ($connessioneDatabase->esegui($insertRisposta) == TRUE) {
                unset($_SESSION["destinatario"]);
                $messaggio = "<p class='messaggio successMessage'>Risposta al messaggio inviata correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/messaggiAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inviare la risposta al messaggio per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/rispostaMessaggioAmministratore.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/rispostaMessaggioAmministratore.php");
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>