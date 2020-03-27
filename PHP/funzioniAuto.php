<?php

require_once "../PHP/connessioneDB.php";

class Veicoli {

    private $connVeicoli='';
    
    /* Il costruttore crea una connessione con il database */
    public function __construct()
    {
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
	public function getAutoAcquista() {
		$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita FROM AutoVendita';

		if(isset($_POST["veicoliDisponibili"])) {
			$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita FROM VeicoliDisponibiliVendita';
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
	public function getAutoNoleggio() {

		$query = 'SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione FROM AutoNoleggio WHERE 1';

		if(isset($_POST["dataInizio"]) && isset($_POST["dataFine"]) && $_POST["dataInizio"] != "" && $_POST["dataFine"] != "") {

			$dataInizio = $_POST["dataInizio"];
			$dataFine = $_POST["dataFine"];

			$query = "SELECT AutoNoleggio.Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione FROM PrenotazioneNoleggio t1
					INNER JOIN
					(
						SELECT PrenotazioneNoleggio.Targa, max(InizioNoleggio) maxData
						FROM PrenotazioneNoleggio
						GROUP BY PrenotazioneNoleggio.Targa
					) AS tmp
					ON t1.Targa = tmp.Targa
					AND t1.InizioNoleggio = tmp.maxData
					RIGHT  JOIN AutoNoleggio on AutoNoleggio.Targa = t1.Targa
					WHERE InizioNoleggio NOT BETWEEN DATE('$dataInizio') AND DATE('$dataFine')
						AND FineNoleggio  NOT BETWEEN DATE('$dataInizio') AND DATE('$dataFine')";
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
				];
				array_push($result,$auto);
			}
			return $result;
		}
	}

	public function isAutoDisponobileDate($idAuto) {

	}
}
?>