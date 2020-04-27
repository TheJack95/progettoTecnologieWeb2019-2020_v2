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

        if(controlloInput::validTesto($_POST["marca"])) {
            $marca = htmlentities($_POST["marca"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La marca inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota&period;</p>";
        }
        
        if(controlloInput::validTesto($_POST["modello"])) {
            $marca = htmlentities($_POST["modello"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il modello inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto&period;</p>";
        }
        
        if(controlloInput::validNumeri($_POST["km"])) {
            $costo = $_POST["km"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il chilometraggio inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto e deve contenere solo numeri&period;</p>";
        }

        if(controlloInput::validNumeri($_POST["cilindrata"])) {
            $cilindrata = $_POST["cilindrata"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cilindrata inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuota e deve contenere solo numeri&period;</p>";
        }
        
        if(controlloInput::validNumeri($_POST["prezzo"])) {
            $costo = $_POST["prezzo"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il costo inserito non &egrave; valido&colon; ricorda che non pu&ograve; essere vuoto e deve contenere solo numeri&period;</p>";
        }
        
        if(is_uploaded_file($_FILES["immagineAuto"]["tmp_name"])) {
            if($_FILES["immagineAuto"]["size"] <= 1000000) {
                $path = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                if(move_uploaded_file($_FILES['immagineAuto']["tmp_name"], $path)) {
                    $immagine = "../Images/". basename($_FILES["immagineAuto"]["name"]);
                }
            } else {
                $valid = false;
                $errori .= "<p class='messaggio errorMessage'>L&apos;immagine inserita non &egrave; valida&colon; ricorda che non pu&ograve; superare i 1000KB&period;</p>";
            }
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>L&apos;immagine non &egrave; stata inserita&period;</p>";
        }

        if(controlloInput::validTesto($_POST["descrizione"])) {
            $descrizione = htmlentities($_POST["descrizione"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La descrizione dell&apos;immagine inserita non &egrave; valida&colon; ricorda che non pu&ograve; essere vuoto&period;</p>";
        }

        if($valid == true) {
            $connessioneDatabase = new database_connection;
            $insert = "INSERT INTO AutoVendita() VALUES ('','$marca','$modello','$km','$cilindrata','$prezzo','$immagine','$descrizione')";
            if ($connessioneDatabase->esegui($insert) == TRUE) {
                unset($_POST["marca"]);
                unset($_POST["modello"]);
                unset($_POST["km"]);
                unset($_POST["cilindrata"]);
                unset($_POST["prezzo"]);
                unset($_FILES["immagineAuto"]["tmp_name"]);
                unset($_POST["descrizione"]);
                $messaggio = "<p class='messaggio successMessage'>Nuovo veicolo in vendita inserito correttamente</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/VeicoliVenditaAmministratore.php");
            } else {
                $messaggio = "<p class='messaggio errorMessage'>Non &egrave; possibile inserire il nuovo veicolo in vendita per un problema del database&period; Riprova&period;</p>";
                $_SESSION["nuovoMessaggio"] = $messaggio;
                header("location: ../PAGES/nuovoVeicoloVendita.php");
            }
        } else {
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/nuovoVeicoloVendita.php");
        }
    } else {
        $errLogin = "ATTENZIONE&excl; Non hai i permessi per accedere all&apos;area dell&apos;amministratore&period;<br />Sei stato reindirizzato alla pagina per l&apos;accesso&period; ACCEDI E RIPROVA&period;";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>
