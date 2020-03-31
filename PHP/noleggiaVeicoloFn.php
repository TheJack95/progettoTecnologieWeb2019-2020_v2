<?php 

    require_once "../PHP/funzioniVeicoli.php";
    require_once "../PHP/funzioniGenerali.php";

    if(!isset($_SESSION))
		session_start();

    $response = (Object) [
        "status" => false
        ,"response" => ""
    ];

	#controllo se i campi obbligatori sono stati inseriti e se sono validi
	if(isset($_POST['dataInizioNolo']) && isset($_POST['dataFineNolo']) && $_POST['dataInizioNolo'] != "" && $_POST['dataFineNolo'] != "") {
        $auto = new funzioniVeicoli();
        $utente  = $_SESSION['utente'];
        $dataInizioNolo  = $_POST['dataInizioNolo'];
        $dataFineNolo  = $_POST['dataFineNolo'];
        $targa  = $_POST['targa'];
        $costo = intval($_GET['costo']);

        $datetime1 = date_create($dataInizioNolo);
        $datetime2 = date_create($dataFineNolo);
        $interval = date_diff($datetime1, $datetime2);
        $costoTotale = $interval->days*$costo;

        $response = $auto->noleggia($utente, $dataInizioNolo, $dataFineNolo, $targa, $costo);

    } else {
        $targa  = $_POST['targa'];
        $response->response = 'Errore: date del noleggio mancanti. Se il problema persiste contatta l\'amministratore. <a href="../PAGES/noleggioVeicolo.php?targaAuto='.$targa.'">Torna indietro</a>';
        $response->status = false;
    }

    $output = funzioniGenerali::setMessaggio($response->response,$response->status);
    $output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);

    echo $output;
?>