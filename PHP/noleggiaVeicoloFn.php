<?php 

require_once "../PHP/funzioniVeicoli.php";
require_once "../PHP/funzioniGenerali.php";
require_once "../PHP/controlloInput.php";

if(!isset($_SESSION))
    session_start();
    
$_SESSION["logged"] = true;
$logged = funzioniGenerali::checkSession();
if($logged->status) {
    $response = (Object) [
        "status" => false
        ,"response" => ""
    ];

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['dataInizioNolo']) && isset($_POST['dataFineNolo']) && $_POST['dataInizioNolo'] != "" && $_POST['dataFineNolo'] != "") {
        $targa  = $_POST['targa'];

        if (controlloInput::checkDateFormat($_POST['dataInizioNolo']) && date_create(controlloInput::validDate($_POST['dataInizioNolo']))
            && controlloInput::checkDateFormat($_POST['dataFineNolo']) && date_create(controlloInput::validDate($_POST['dataFineNolo']))){

            $auto = new funzioniVeicoli();
            $utente  = $_SESSION['user'];
            $dataInizioNolo  = $_POST['dataInizioNolo'];
            $dataFineNolo  = $_POST['dataFineNolo'];
            $costo = intval($_GET['costo']);

            $datetime1 = date_create($dataInizioNolo);
            $datetime2 = date_create($dataFineNolo);
            $interval = date_diff($datetime1, $datetime2);
            $costoTotale = $interval->days*$costo;

            $response = $auto->noleggia($utente, $datetime1, $datetime2, $targa, $costo);
        } else {
            $response->response = 'Attenzione: il formato delle date non &egrave; corretto. Deve essere gg-mm-aaaa. <a href="../PAGES/noleggioVeicolo.php?targaAuto='.$targa.'">Torna indietro</a>';
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