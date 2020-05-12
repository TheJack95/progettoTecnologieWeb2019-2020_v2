<?php
    require_once "../PHP/connessioneDB.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
        $valid = true;
        $errori = "";

        if(isset($_SESSION["targa"])) {
            $targa = $_SESSION["targa"];
        } else {
            $valid = false;
            $reeori .= "<p class='messaggio errorMessage'>Non &egrave; possibile modificare le informazioni del veicolo a noleggio per un problema del database&#46; Riprova pi&ugrave; tardi&#46;</p>";
        }
        
        if(controlloInput::validTesto($_POST["marca"])) {
            $marca = htmlentities($_POST["marca"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La marca inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota&#46;</p>";
        }
        
        if(controlloInput::validTesto($_POST["modello"])) {
            $modello = htmlentities($_POST["modello"],ENT_QUOTES,"UTF-8");
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il modello inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto&#46;</p>";
        }
        
        if(controlloInput::validNumeri($_POST["cilindrata"])) {
            $cilindrata = $_POST["cilindrata"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cilindrata inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e che pu&ograve; contenere solo numeri&#46;</p>";
        }
        
        if(controlloInput::validNumeri($_POST["costo"])) {
            $costo = $_POST["costo"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>Il costo inserito non &egrave; valido&#58; ricorda che non pu&ograve; essere vuoto e che pu&ograve contenere solo numeri&#46;</p>";
        }
        
        if(controlloInput::validNumeri($_POST["cauzione"])) {
            $cauzione = $_POST["cauzione"];
        } else {
            $valid = false;
            $errori .= "<p class='messaggio errorMessage'>La cauzione inserita non &egrave; valida&#58; ricorda che non pu&ograve; essere vuota e che pu&ograve; contenere solo numeri&#46;</p>";
        }

        if($valid == true) {
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
            $_SESSION["nuovoMessaggio"] = $errori;
            header("location: ../PAGES/nuovoVeicoloNoleggio.php");
        }
    } else {
        $errLogin = "Attenzione&#58; non hai i permessi per accedere all&#39;area dell&#39;amministratore&#46; Sei stato reindirizzato alla pagina per l&#39;accesso&#46; Accedi e riprova";
        $_SESSION["errmessage"] = $errLogin;
        header("location: ../PAGES/login.php");
    }
?>