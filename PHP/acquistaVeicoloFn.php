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
	if(isset($_GET['idAuto']) && isset($_GET['prezzoVendita'])) {
        $auto = new funzioniVeicoli();
        $utente  = "admin@admin.com"; //$_SESSION['utente'];
        $idAuto  = $_GET['idAuto'];
        $prezzoVendita = intval($_GET['prezzoVendita']);

        $response = $auto->richiediPreventivo($utente, $idAuto, $prezzoVendita);

    } else {
        $response->response = 'Errore imprevisto, riprovare. Se il problema persiste contatta l\'amministratore.';
        $response->status = false;
    }

    $output = funzioniGenerali::setMessaggio($response->response,$response->status);
    $output = str_replace('<a href="home.php">','<a href="../PAGES/home.php">',$output);

    echo $output;
?>