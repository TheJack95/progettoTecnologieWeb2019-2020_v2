<?php

require_once "../PHP/connessioneDB.php";

class funzioniVeicoli {

    private $connVeicoli='';
    
    /* Il costruttore crea una connessione con il database */
    public function __construct() {
        $this->connVeicoli = new database_connection();
    }

	/**
	* Funzione per la creazione della clausola where della query
	* @param string $table la tabella in cui cercare
	* @return string la clausola where
	*/
	private function makeWhereClause($table) {
		$where = "";

		if(isset($_POST["searchbar"]) && $_POST["searchbar"] != "" ) {
			$searchbar = $_POST["searchbar"];
			$where  .= "Marca LIKE '%$searchbar%'
						OR Modello LIKE '%$searchbar%'
						OR Cilindrata LIKE '%$searchbar%' ";

			if($table == "AutoVendita") {
				$where  .= "OR KM LIKE '%$searchbar%'
							OR PrezzoVendita LIKE '%$searchbar%' ";
			} else {
				$where  .= "OR CostoNoleggio LIKE '%$searchbar%'
							OR Cauzione LIKE '%$searchbar%' ";
			}
		}
		
		return $where;
	}

	/**
	* Funzione per la creazione della lista delle auto disponibili per l'acquisto. Esegue Select * From AutoVendita
	* @return array la lista delle auto prese dal DB
	*/
	public function getVeicoliAcquista() {
		$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita, Immagine, DescrImmagine FROM AutoVendita';

		if(isset($_POST["veicoliDisponibili"])) {
			$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita, Immagine, DescrImmagine FROM VeicoliDisponibiliVendita';
		}

		$where = $this->makeWhereClause("AutoVendita");

		if($where != "") {
			$query .= " WHERE $where";
		}

		$queryResult = $this->connVeicoli->esegui($query);
		$_POST = array();
		
		if($queryResult == false) {
			return [];
		} else {
			$result = array();
			while($row=mysqli_fetch_assoc($queryResult)) {
				$auto = (Object) [
					"IdAuto" => $row['IdAuto']
					,"Marca" => $row['Marca']
					,"Modello" => $row['Modello']
					,"Cilindrata" => $row['Cilindrata']
					,"PrezzoVendita" => $row['PrezzoVendita']
					,"KM" => $row['KM']
					,"Immagine" => $row['Immagine']
					,"DescrImmagine" => $row['DescrImmagine']
				];
				array_push($result,$auto);
			}
			return $result;
		}
	}

	/**
	* Funzione per la creazione della lista delle auto disponibili per il noleggio. Esegue Select * From AutoNoleggio
	* @return array la lista delle auto prese dal DB
	*/
	public function getVeicoliNoleggio() {

		$query = 'SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione, Immagine, DescrImmagine FROM AutoNoleggio WHERE 1';
		
		$where = $this->makeWhereClause("AutoNoleggio");

		if($where != "") {
			$query .= " AND $where";
		}

		$queryResult = $this->connVeicoli->esegui($query);
		$_POST = array();

		if($queryResult == false) {
			return [];
		} else {
			$result = array();
			while($row=mysqli_fetch_assoc($queryResult)) {
				$auto = (Object) [
					"Targa" => $row['Targa']
					,"Marca" => $row['Marca']
					,"Modello" => $row['Modello']
					,"Cilindrata" => $row['Cilindrata']
					,"CostoNoleggio" => $row['CostoNoleggio']
					,"Cauzione" => $row['Cauzione']
					,"Immagine" => $row['Immagine']
					,"DescrImmagine" => $row['DescrImmagine']
				];
				array_push($result,$auto);
			}
			return $result;
		}
	}

	/**
	* Funzione che controlla se un'auto sia disponibile al momento del noleggio
	* @param $targa 
	* @return bool
	*/
	public function isAutoDisponobileDate($targa, $dataInizio,  $dataFine) {

		$dataInizioString = $dataInizio->format('Y-m-d');
		$dataFineString = $dataFine->format('Y-m-d');
		$query = "SELECT Targa
				FROM PrenotazioneNoleggio
				WHERE (InizioNoleggio BETWEEN DATE('$dataInizioString') AND DATE('$dataFineString')
					OR FineNoleggio  BETWEEN DATE('$dataInizioString') AND DATE('$dataFineString')
					OR DATE('$dataInizioString') BETWEEN InizioNoleggio AND FineNoleggio)
					AND Targa = '$targa'";
		$queryResult = $this->connVeicoli->esegui($query, false);

		if($queryResult === false) {
			return false;
		} else {
			return $queryResult->num_rows == 0;
		}
	}

	/**
	* Funzione che controlla se un utente ha già richiesto un preventivo per la stessa auto
	* Ritorna true se l'utente ha già richiesto un preventivo per la stessa auto
	* @param $idAuto 
	* @param $utente 
	* @return bool
	*/
	public function preventivoGiaRichiesto($idAuto, $utente) {
		$query = "SELECT IdPrev
				FROM PreventivoAcquisto
				WHERE Automobile = '$idAuto' AND Utente  = '$utente'";
		$queryResult = $this->connVeicoli->esegui($query, false);

		if($queryResult === false) {
			return false;
		} else {
			return $queryResult->num_rows;
		}
	}

	/**
	* Funzione per prenotare l'auto
	* @return Object status: true/false, response: messaggio di risposta
	*/
	public function noleggia(string $utente, $dataInizioNolo, $dataFineNolo,string $targa, int $costo, $chiudiConn = true) {

		$response = (Object) [
			"status" => false
			,"response" => ""
			,"query" => ""
		];

		$dataInizioString = $dataInizioNolo->format('Y-m-d');
		$dataFineString = $dataFineNolo->format('Y-m-d');
		
		$query = "INSERT INTO PrenotazioneNoleggio VALUES(null,'$utente', '$targa', '$dataInizioString', '$dataFineString', $costo)";
		$queryResult = $this->connVeicoli->esegui($query, $chiudiConn);
		
		if($queryResult === false) {
			$response->response = "Errore nella comunicazione con il database.";
			$response->query = $query;
		} else {
			$response->status = true;
			$response->response = "Noleggio auto avvenuto correttamente.";
		}
		
		return $response;
	}

	/**
	* Funzione per richiedere un preventivoAuto dell'auto
	* @return Object status: true/false, response: messaggio di risposta
	*/
	public function richiediPreventivo(string $utente, string $idAuto, string $prezzoVendita, $chiudiConn = true) {
		
		$response = (Object) [
			"status" => false
			,"response" => ""
		];

		$autoGiaRichiesta = $this->preventivoGiaRichiesto($_GET['idAuto'], $_SESSION['user']);
		if($autoGiaRichiesta === 0) {
			$query = "INSERT INTO PreventivoAcquisto VALUES(null,'$utente', $idAuto, '$prezzoVendita')";
			$queryResult = $this->connVeicoli->esegui($query);
			if($queryResult === false) {
				$response->response = "Errore nella comunicazione con il database.";
			} else {
				$response->status = true;
				$response->response = "Preventivo richiesto correttamente ";
			}
		} else {
			if($autoGiaRichiesta === false) {
				$response->response = 'Errore imprevisto, riprovare. Se il problema persiste contatta l&apos;amministratore.';
			} else {
				$response->response = 'Attenzione, hai gi&agrave; richiesto un preventivo per quest&apos;auto. Attendi la risposta dell&apos;amministratore';
			}
		}
		
		return $response;
	}

	/**
	* Funzione per leggere dati dell'auto a noleggio dal db
	* @param string $targa la targa del veicolo 
	* @return string il risultato della query
	*/
	public function getVeicoloNoleggio(string $targa, $chiudiConn = true) {
		$query = "SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione, Immagine, DescrImmagine FROM AutoNoleggio WHERE Targa = '$targa'";

		$queryResult = $this->connVeicoli->esegui($query, $chiudiConn);

		if($queryResult == false) {
			return "Errore nella comunicazione con il database";
		} else {
			$row =  mysqli_fetch_assoc($queryResult);
			$auto = (Object) [
				"Targa" => $row['Targa']
				,"Marca" => $row['Marca']
				,"Modello" => $row['Modello']
				,"Cilindrata" => $row['Cilindrata']
				,"CostoNoleggio" => $row['CostoNoleggio']
				,"Cauzione" => $row['Cauzione']
				,"Immagine" => $row['Immagine']
				,"DescrImmagine" => $row['DescrImmagine']
			];
			return $auto;
		}
	}

	/**
	* Funzione per leggere dati dell'auto in vendita dal db
	* @param string $idAuto id del veicolo 
	* @return string il risultato della query
	*/
	public function getVeicoloAcquista(string $idAuto, $chiudiConn = true) {
		$query = "SELECT idAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita, Immagine, DescrImmagine FROM AutoVendita WHERE idAuto = '$idAuto'";

		$queryResult = $this->connVeicoli->esegui($query, $chiudiConn);

		if($queryResult == false) {
			return "Errore nella comunicazione con il database";
		} else {
			$row =  mysqli_fetch_assoc($queryResult);
			$auto = (Object) [
				"idAuto" => $row['idAuto']
				,"Marca" => $row['Marca']
				,"Modello" => $row['Modello']
				,"Cilindrata" => $row['Cilindrata']
				,"KM" => $row['KM']
				,"PrezzoVendita" => $row['PrezzoVendita']
				,"Immagine" => $row['Immagine']
				,"DescrImmagine" => $row['DescrImmagine']
			];
			return $auto;
		}
	}

}
?>