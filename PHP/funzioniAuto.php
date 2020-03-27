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
	* Funzione per la creazione della lista delle auto disponibili per l'acquisto
	* @return array la lista delle auto prese dal DB
	*/
	public function getAutoAcquista() {
		$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita FROM AutoVendita';
		$queryResult = $this->connVeicoli->esegui($query);

		if(mysqli_num_rows($queryResult)==0) {
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
	* Funzione per la creazione della lista delle auto disponibili per il noleggio
	* @return array la lista delle auto prese dal DB
	*/
	public function getAutoNoleggio() {
		$query = 'SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione FROM AutoNoleggio';
		$queryResult = $this->connVeicoli->esegui($query);

		if(mysqli_num_rows($queryResult)==0) {
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


}
?>