<?php
    require_once "../PHP/controlloInput.php";
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $errori = "";
        $valid = true;

        if(isset($_SESSION["user"])) {
            $email = $_SESSION["user"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni personali per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
        }

        if(controlloInput::validName($_POST["nome"])) {
            $nome = htmlentities($_POST["nome"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il nome inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }

        if(controlloInput::validName($_POST["cognome"])) {
            $cognome = htmlentities($_POST["cognome"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il cognome inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }

        if(controlloInput::validPhone($_POST["telefono"])) {
            $telefono = $_POST["telefono"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il numero di telefono inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto e che deve essere valido&#46;</p>";
        }

        if(controlloInput::validAddress($_POST["indirizzo"])) {
            $indirizzo = htmlentities($_POST["indirizzo"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&#39;indirizzo inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }

        if(controlloInput::checkDateFormat($_POST["nascita"])) {
            $nascita = date('Y-m-d',strtotime($_POST["nascita"]));
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La data di nascita inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e che deve essere nel formato gg&#8722;mm&#8722;aaaa&#46;</p>";
        }

        if($valid == true) {
            $connessioneDatabase = new database_connection;
            $update = "UPDATE Utenti SET Nome='$nome', Cognome='$cognome', Telefono='$telefono', Indirizzo='$indirizzo', DataNascita='$nascita' WHERE Email='$email'";
            if ($connessioneDatabase->esegui($update) == TRUE) {
                $messaggio = "<p class='messaggio successMessage'>Le informazioni personali sono state modificate correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/infoAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni personali per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/modificaInfoAmministratore.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/modificaInfoAmministratore.php");
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>