<?php

class Veicoli {

    private $veicoli='';

    private const host = 'localhost';
	private const user = 'admin';
	private const pass = 'admin';
    private const dbName = 'TecWeb';
    
    /* Il costruttore crea una connessione con il database */
    public function __construct()
    {
        if (!($this->veicoli = @mysqli_connect(static::host, static::user, static::pass, static::dbName))) {
            error_log("Debugging errno: " . mysqli_connect_errno()."Debugging error: " . mysqli_connect_error());
            echo "Momentaneamente i dati non sono disponibili. Riprovare più tardi.";
        }
    }

	/**
	* Funzione per la creazione della lista delle auto disponibili per l'acquisto
	* @return array la lista delle auto prese dal DB
	*/
	public function getAutoAcquista() {
		$query = 'SELECT IdAuto, Marca, Modello, Cilindrata, KM, PrezzoVendita FROM AutoVendita';
		$queryResult = mysqli_query($this->veicoli,$query);

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
		$queryResult = mysqli_query($this->veicoli,$query);

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