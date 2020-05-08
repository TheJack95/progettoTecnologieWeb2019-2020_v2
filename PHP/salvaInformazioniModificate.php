<?php
    require_once "../PHP/connessioneDB.php";
    require_once "../PHP/controlloInput.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["user"])) {
        $messaggio = "";
        $valid = true;

        if($valid == true) {
            $email = $_SESSION["user"];
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $telefono = $_POST["telefono"];
            $indirizzo = $_POST["indirizzo"];
            if(!empty($_POST["nascita"])) {
                $nascita = date('Y-m-d',strtotime($_POST["nascita"]));
            } else {
                $nascita = "";
            }

            $connessioneDatabase = new database_connection;
            $update = "UPDATE Utenti SET Nome='$nome', Cognome='$cognome', Telefono='$telefono', Indirizzo='$indirizzo', DataNascita='$nascita' WHERE Email='$email'";
            if ($connessioneDatabase->esegui($update) == TRUE) {
                $messaggio .= "<p class='messaggio successMessage'>Le informazioni personali sono state modificate correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/infoAmministratore.php");
            } else {
                $messaggio .= "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni personali per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/modificaInfoAmministratore.php");
            }
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>