<?php 
    echo var_dump($_POST);

    require_once "../PHP/funzioniVeicoli.php";
    require_once "../PHP/funzioniGenerali.php";

    if(!isset($_SESSION))
		session_start();

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['dataInizioNolo']) && isset($_POST['dataFineNolo']) && $_POST['dataInizioNolo'] != "" && $_POST['dataFineNolo'] != "") {
        $auto = new funzioniVeicoli();
        $utente  = "admin@admin.com"; //$_SESSION['utente'];
        $dataInizioNolo  = $_POST['dataInizioNolo'];
        $dataFineNolo  = $_POST['dataFineNolo'];
        $targa  = $_POST['targa'];
        $costo = intval($_GET['costo']);

        $datetime1 = date_create($dataInizioNolo);
        $datetime2 = date_create($dataFineNolo);
        $interval = date_diff($datetime1, $datetime2);
        $costoTotale = $interval->days*$costo;

        $response = $auto->prenotaAuto($utente, $dataInizioNolo, $dataFineNolo, $targa, $costo);

        echo funzioniGenerali::setMessaggio($response->response,$response->status);
    }
?>