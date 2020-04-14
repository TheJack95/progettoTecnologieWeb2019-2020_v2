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

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['dataInizioNolo']) && isset($_POST['dataFineNolo']) && $_POST['dataInizioNolo'] != "" && $_POST['dataFineNolo'] != "") {
        $targa  = $_GET['targaAuto'];

        if (controlloInput::checkDateFormat($_POST['dataInizioNolo']) && controlloInput::validDate($_POST['dataInizioNolo'])
            && controlloInput::checkDateFormat($_POST['dataFineNolo']) && controlloInput::validDate($_POST['dataFineNolo'])) {
            
            $dataFineNolo = date_create($_POST['dataFineNolo']);
            $dataInizioNolo = date_create($_POST['dataInizioNolo']);  

            if($dataFineNolo >= $dataInizioNolo) {
                $conn = new funzioniVeicoli();
                $auto = $conn->getVeicoloNoleggio($targa, false);
                $utente  = $_SESSION['user'];
                $costo = intval($auto->CostoNoleggio);
                
                $interval = date_diff($dataInizioNolo, $dataFineNolo);
                $costoTotale = $interval->days*$costo;
    
                $response = $conn->noleggia($utente, $datetime1, $datetime2, $targa, $costo);
            } else {
                $response->response = 'La data di fine noleggio deve essere successiva o uguale alla data di inizio. <a href="../PAGES/noleggioVeicolo.php?targaAuto='.$targa.'">Torna indietro</a>';
                $response->status = false;
            }
        } else {
            $response->response = 'Attenzione: il formato delle date non &egrave; corretto. Le date devono essere successive ad oggi. Deve essere gg-mm-aaaa. <a href="../PAGES/noleggioVeicolo.php?targaAuto='.$targa.'">Torna indietro</a>';
            $response->status = false;
        }

    } else {
        $targa  = $_POST['targa'];
        $response->response = 'Errore: date del noleggio mancanti. Se il problema persiste contatta l&apos;amministratore. <a href="../PAGES/noleggioVeicolo.php?targaAuto='.$targa.'">Torna indietro</a>';
        $response->status = false;
    }

    $output = funzioniGenerali::setMessaggio($response->response,!$response->status);
    $output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);

    echo $output;
} else {
    $logged->message = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$logged->message);
    echo $logged->message;
	//header("refresh:5; url= ../PAGES/login.php");
}
?>