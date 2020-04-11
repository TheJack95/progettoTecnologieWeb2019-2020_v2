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
			$where  .= "Marca LIKE '$searchbar'
						OR Modello LIKE '$searchbar'
						OR Cilindrata LIKE '$searchbar' ";

			if($table == "AutoVendita") {
				$where  .= "OR KM LIKE '$searchbar'
							OR PrezzoVendita LIKE '$searchbar' ";
			} else {
				$where  .= "OR CostoNoleggio LIKE '$searchbar'
							OR Cauzione LIKE '$searchbar' ";
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

		if(isset($_POST["dataInizio"]) && isset($_POST["dataFine"]) && $_POST["dataInizio"] != "" && $_POST["dataFine"] != "") {

			$dataInizio = $_POST["dataInizio"];
			$dataFine = $_POST["dataFine"];

			$query = "SELECT AutoNoleggio.Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione, Immagine, DescrImmagine FROM PrenotazioneNoleggio t1
					INNER JOIN
					(
						SELECT PrenotazioneNoleggio.Targa, max(InizioNoleggio) maxData
						FROM PrenotazioneNoleggio
						GROUP BY PrenotazioneNoleggio.Targa
					) AS tmp
					ON t1.Targa = tmp.Targa
					AND t1.InizioNoleggio = tmp.maxData
					RIGHT JOIN AutoNoleggio on AutoNoleggio.Targa = t1.Targa
					WHERE InizioNoleggio NOT BETWEEN DATE('$dataInizio') AND DATE('$dataFine')
						AND FineNoleggio  NOT BETWEEN DATE('$dataInizio') AND DATE('$dataFine')
						AND DATE('$dataInizio') NOT BETWEEN InizioNoleggio AND FineNoleggio";
		}
		
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
	* Funzione che controlla se un'auto &egrave; disponibile al momento dell'acquisto
	* @param int $idAuto 
	* @return bool
	*/
	public function isAutoDisponobileDate(int $idAuto) {

	}

	/**
	* Funzione per prenotare l'auto
	* @return Object status: true/false, response: messaggio di risposta
	*/
	public function noleggia(string $utente, $dataInizioNolo, $dataFineNolo,string $targa, int $costo, $chiudiConn = true) {
		$dataInizioString = $dataInizioNolo->format('Y-m-d');
		$dataFineString = $dataFineNolo->format('Y-m-d');
		$query = "INSERT INTO PrenotazioneNoleggio VALUES(null,'$utente', '$targa', '$dataInizioString', '$dataFineString', $costo)";
		$queryResult = $this->connVeicoli->esegui($query, $chiudiConn);
		if($queryResult === false) {
			return (Object) [
				"status" => false
				,"response" => "Errore nella comunicazione con il database"
				,"query" => $query
			];
		} else {
			return (Object) [
				"status" => true
				,"response" => "Noleggio auto avvenuto correttamente"
			];
		}
	}

	/**
	* Funzione per richiedere un preventivoAuto dell'auto
	* @return Object status: true/false, response: messaggio di risposta
	*/
	public function richiediPreventivo(string $utente, string $idAuto, string $prezzoVendita, $chiudiConn = true) {
		$query = "INSERT INTO PreventivoAcquisto VALUES(null,'$utente', $idAuto, '$prezzoVendita')";
		$queryResult = $this->connVeicoli->esegui($query);
		if($queryResult === false) {
			return (Object) [
				"status" => false
				,"response" => "Errore nella comunicazione con il database."
			];
		} else {
			return (Object) [
				"status" => true
				,"response" => "Preventivo richiesto correttamente."
			];
		}
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