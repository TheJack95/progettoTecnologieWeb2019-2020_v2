<?php
    class funzioniAmministratore {
    #credenziali per il database
        const host = 'localhost';
	    const user = 'admin';
	    const pass = 'admin';
	    const dbName = 'tecweb';
    #funzione per la connessione al database
        public function apriConnessioneDB() {
            $connection = "";
            $this->connection = mysqli_connect(static::host,static::user,static::pass,static::dbName);
            if(!$this->connection){
                return false;
            } else{
                return true;
            }
        }

    #funzione per il menù dell'area personale dell'amministratore
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'.
                                '<ul>'.
                                    '<li><a href="homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a></li>'.
                                    '<li><a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a></li>'.
                                    '<li><a href="messaggiAmministratore.php">MESSAGGI</a></li>'.
                                    '<li><a href="veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a></li>'.
                                    '<li><a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a></li>'.
                                '</ul>'.
                            '</div>';
            return $menuAmm_form;
        }
    
    #funzione per la lettura da database del nome dell'utente
        public function selectNomeUtente() {
#            $identita = $_SESSION['email'];
            $identita = " ";
            $query = 'SELECT Nome FROM Utenti WHERE Email=\''.$identita.'\'';
            $queryNomeUtente = mysqli_query($this->connection,$query);
            if(mysqli_num_rows($queryNomeUtente)==0){
                return null;
            } else{
                return $queryNomeUtente;
            }
        }
    
    #funzione per la lettura da database delle informazioni dell'utente
        public function selectInfoPersonali() {
#            $identita = $_SESSION['email'];
            $identita = " ";
            $query = 'SELECT Email, Nome, Cognome, Telefono, Indirizzo, DataNascita FROM Utenti WHERE Email=\''.$identita.'\'';
            $queryResult = mysqli_query($this->connection,$query);
            if(mysqli_num_rows($queryResult)==0){
                return null;
            } else{
                $infoPersonali = array();
                while($row=mysqli_fetch_assoc($queryResult)){
                    $arrayInfoPersonali = array('Email'=>$row['Email'],'Nome'=>$row['Nome'],'Cognome'=>$row['Cognome'],'Telefono'=>$row['Telefono'],'Indirizzo'=>$row['Indirizzo'],'DataNascita'=>$row['DataNascita']);
                    array_push($infoPersonali,$arrayInfoPersonali);
                }
                return $infoPersonali;
            }
        }

    #funzione per la lettura da database dei veicoli a noleggio
        public function selectVeicoliNoleggio() {
            $query = 'SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione FROM AutoNoleggio ORDER BY Marca GROUP BY Modello ASC';
            $queryResult = mysqli_query($this->connection,$query);
            if(mysqli_num_rows($queryResult)==0){
		        return null;
	        } else{
                $veicoliNoleggio = array();
                while($row=mysqli_fetch_assoc($queryResult)){
                    $arrayVeicoloNoleggio = array('Targa'=>$row['Targa'],'Marca'=>$row['Marca'],'Modello'=>$row['Modello'],'Cilindrata'=>$row['Cilindrata'],'CostoNoleggio'=>$row['CostoNoleggio'],'Cauzione'=>$row['Cauzione']);
                    array_push($veicoliNoleggio,$arrayVeicoloNoleggio);
                }
                return $veicoliNoleggio;
            }
        }

    #funzione per la lettura da database dei veicoli in vendita
        public function selectVeicoliVendita() {
            $query = 'SELECT Marca, Modello, KM, Cilindrata, PrezzoVendita FROM AutoAutoVendita ORDER BY Marca GROUP BY Modello ASC';
            $queryResult = mysqli_query($this->connection,$query);
            if(mysqli_num_rows($queryResult)==0){
		        return null;
	        } else{
                $veicoliVendita = array();
                while($row=mysqli_fetch_assoc($queryResult)){
                    $arrayVeicoloVendita = array('Marca'=>$row['Marca'],'Modello'=>$row['Modello'],'KM'=>$row['KM'],'Cilindrata'=>$row['Cilindrata'],'PrezzoVendita'=>$row['PrezzoVendita']);
                    array_push($veicoliVendita,$arrayVeicoloVendita);
                }
                return $veicoliVendita;
            }
        }

    #funzione per l'inserimento nel database di un nuovo veicolo a noleggio
        public function insertVeicoloNoleggio() {
            $targa = $_POST['targa'];
            $marca = $_POST['marca'];
            $modello = $_POST['modello'];
            $cilindrata = $_POST['cilindrata'];
            $costoNoleggio = $_POST['costoNoleggio'];
            $cauzione = $_POST['cauzione'];
            
            $insertVeicoloNoleggio = "INSERT INTO AutoNoleggio() VALUES ('$targa','$marca','$modello','$cilindrata','$costoNoleggio','$cauzione')";
            if($this->connection->query($insertVeicoloNoleggio) === TRUE){
                return true;
            } else{
                return false;
            }
        }

    #funzione per l'inserimento nel database di un nuovo veicolo in vendita
        public function insertVeicoloVendita() {
            $idAuto = $_POST['idAuto'];
            $marca = $_POST['marca'];
            $modello = $_POST['modello'];
            $km = $_POST['km'];
            $cilindrata = $_POST['cilindrata'];
            $prezzoVendita = $_POST['prezzoVendita'];
            
            $insertVeicoloVendita = "INSERT INTO AutoVendita() VALUES ('$idAuto','$marca','$modello','$km','$cilindrata','$prezzoVendita')";
            if($this->connection->query($insertVeicoloVendita) === TRUE){
                return true;
            } else{
                return false;
            }
        }

    #funzione per l'inserimento nel database di un nuovo messaggio
        public function insertRisposta() {
            $destinatario = $_POST['destinatario'];
            $oggetto = $_POST['oggetto'];
            $testo = $_POST['testo'];

            $insertRisposta = "INSERT INTO MessaggiRisposta() VALUES ('$destinatario','$oggetto','$testo')";
            if ($this->connection->query($insertRisposta) === TRUE){
                return true;
            } else{
                return false;
            }
        }
    }
?>
