<?php
    require_once "../PHP/controlloInput.php";
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $valid = true;
        $errori = "";
        $immagine = "";
        
        if(controlloInput::validTarga($_POST["targa"])) {
            $targa = $_POST["targa"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La targa inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e deve avere esattamente sette caratteri&#46;</p>";
        }
        
        if(controlloInput::validTestoCorto($_POST["marca"])) {
            $marca = htmlentities($_POST["marca"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La marca inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota&#46;</p>";
        }
        
        if(controlloInput::validTestoCorto($_POST["modello"])) {
            $modello = htmlentities($_POST["modello"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il modello inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }
        
        if(controlloInput::validCilindrata($_POST["cilindrata"])) {
            $cilindrata = $_POST["cilindrata"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cilindrata inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e che pu&ograve; contenere solo numeri&#46;</p>";
        }
        
        if(controlloInput::validPrezzo($_POST["costo"])) {
            $costo = $_POST["costo"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il costo inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto e che pu&ograve contenere solo numeri&#46;</p>";
        }
        
        if(controlloInput::validPrezzo($_POST["cauzione"])) {
            $cauzione = $_POST["cauzione"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cauzione inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e che pu&ograve; contenere solo numeri&#46;</p>";
        }

        if(is_uploaded_file($_FILES["immagineAuto"]["tmp_name"])) {
            if($_FILES["immagineAuto"]["size"] <= 1000000) {
                $path = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                if(move_uploaded_file($_FILES['immagineAuto']["tmp_name"], $path)) {
                    $immagine = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                }
            } else {
                $valid = false;
                $errori .= "<p class='messaggio errorMessage'>L&#39;immagine inserita non &egrave; valida&#58; ricorda che non pu&ograve; superare i 1000KB&#46;</p>";
            }
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&#39;immagine non &egrave; stata inserita&#46;</p>";
        }

        if(controlloInput::validDescr($_POST["descrizione"])) {
            $descrizione = htmlentities($_POST["descrizione"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La descrizione dell&#39;immagine inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota&#46;</p>";
        }

        if($valid == true) {
            $connessioneDatabase = new database_connection;
            $insert = "INSERT INTO AutoNoleggio() VALUES ('$targa','$marca','$modello','$cilindrata','$costo','$cauzione','$immagine','$descrizione')";
            if ($connessioneDatabase->esegui($insert) == TRUE) {
                $messaggio = "<p class='messaggio successMessage'>Nuovo veicolo a noleggio inserito correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inserire il nuovo veicolo a noleggio per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/nuovoVeicoloNoleggio.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/nuovoVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>