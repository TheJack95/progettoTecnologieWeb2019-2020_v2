<?php 

require_once "../PHP/funzioniVeicoli.php";
require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/controlloInput.php";


$logged = funzioniGenerali::checkSession();
if($logged->status) {
    $response = (Object) [
        "status" => false
        ,"response" => ""
    ];

    $targa  = $_GET['targaAuto'];

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
    if(isset($_POST['dataInizioNolo']) && isset($_POST['dataFineNolo']) && $_POST['dataInizioNolo'] != "" && $_POST['dataFineNolo'] != "") {

        if (controlloInput::checkDateFormat($_POST['dataInizioNolo']) && controlloInput::validDate($_POST['dataInizioNolo'])
            && controlloInput::checkDateFormat($_POST['dataFineNolo']) && controlloInput::validDate($_POST['dataFineNolo'])) {
            
            $dataFineNolo = date_create($_POST['dataFineNolo']);
            $dataInizioNolo = date_create($_POST['dataInizioNolo']);  
            $conn = new funzioniVeicoli();
            if($conn->isAutoDisponobileDate($targa, $dataInizioNolo, $dataFineNolo)) {

                if($dataFineNolo >= $dataInizioNolo) {
        
                    $auto = $conn->getVeicoloNoleggio($targa, false);
                    $utente  = $_SESSION['user'];
                    $costo = intval($auto->CostoNoleggio);
                    
                    $interval = date_diff($dataInizioNolo, $dataFineNolo);
                    $costoTotale = $interval->days*$costo;
        
                    $response = $conn->noleggia($utente, $dataInizioNolo, $dataFineNolo, $targa, $costo);
                } else {
                    $response->response = 'La data di fine noleggio deve essere successiva o uguale alla data di inizio.';
                    $response->status = false;
                }
            } else {
                $response->response = 'Attenzione: l&apos;auto selezionata non &egrave; disponibile nelle date selezionate.';
                $response->status = false;
            }
        } else {
            $response->response = 'Attenzione: il formato delle date non &egrave; corretto. Le date devono essere successive ad oggi. Deve essere gg-mm-aaaa.';
            $response->status = false;
        }

    } else {
        $response->response = 'Errore: date del noleggio mancanti. Se il problema persiste contatta l&apos;amministratore.';
        $response->status = false;
    }
    
    if($response->status) {
        $output = funzioniGenerali::setMessaggio($response->response.' <a href="../PAGES/home.php">Torna alla home</a>', false);
        echo $output;
    } else {
        $_SESSION["noleggioError"] = $response->response;
        header("location: ../PAGES/noleggioVeicolo.php?targaAuto=$targa");
    }
} else {
    echo str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$logged->message);
}
?>