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
            $errori .= "<p class='messaggio errorMessage'>La targa inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota e deve avere sette caratteri</p>";
        }
        
        if(controlloInput::validTesto($_POST["marca"])) {
            $marca = htmlentities($_POST["marca"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La marca inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota</p>";
        }
        
        if(controlloInput::validTesto($_POST["modello"])) {
            $marca = htmlentities($_POST["modello"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il modello inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto</p>";
        }
        
        if(controlloInput::validNumeri($_POST["cilindrata"])) {
            $cilindrata = $_POST["cilindrata"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cilindrata inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota e deve contenere solo numeri</p>";
        }
        
        if(controlloInput::validNumeri($_POST["costo"])) {
            $costo = $_POST["costo"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il costo inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto e deve contenere solo numeri</p>";
        }
        
        if(controlloInput::validNumeri($_POST["cauzione"])) {
            $cauzione = $_POST["cauzione"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cauzione inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota e deve contenere solo numeri</p>";
        }

        if(is_uploaded_file($_FILES["immagineAuto"]["tmp_name"])) {
            if($_FILES["immagineAuto"]["size"] <= 1000000) {
                $path = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                if(move_uploaded_file($_FILES['immagineAuto']["tmp_name"], $path)) {
                    $immagine = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                }
            } else {
                $valid = false;
                $errori .= "<p class='messaggio errorMessage'>L&apos;immagine inserita non &egrave; valida&colon; ricorda che non pu&ograve; superare i 1000KB</p>";
            }
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&apos;immagine non &egrave; stata inserita</p>";
        }

        if(controlloInput::validTesto($_POST["descrizione"])) {
            $descrizione = htmlentities($_POST["descrizione"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La descrizione dell&apos;immagine inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota</p>";
        }

        if($valid == true) {
            $connessioneDatabase = new database_connection;
            $insert = "INSERT INTO AutoNoleggio() VALUES ('$targa','$marca','$modello','$cilindrata','$costo','$cauzione','$immagine','$descrizione')";
            if ($connessioneDatabase->esegui($insert) == TRUE) {
                unset($_POST["targa"]);
                unset($_POST["marca"]);
                unset($_POST["modello"]);
                unset($_POST["cilindrata"]);
                unset($_POST["costo"]);
                unset($_POST["cauzione"]);
                unset($_FILES["immagine"]["tmp_name"]);
                unset($_POST["descrizione"]);
                $messaggio = "<p class='messaggio successMessage'>Nuovo veicolo a noleggio inserito correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/VeicoliNoleggioAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inserire il nuovo veicolo a noleggio per un problema del database, riprova</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/nuovoVeicoloNoleggio.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/nuovoVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "ATTENZIONE&colon; non hai i permessi per accedere all&apos;area dell&apos;amministratore. Sei stato reindirizzato alla pagina per l&apos;accesso. Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
