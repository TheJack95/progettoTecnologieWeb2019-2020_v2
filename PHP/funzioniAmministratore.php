<?php
    require_once "../PHP/connessioneDB.php";

    class funzioniAmministratore {
    #funzione per il menu dell'area personale dell'amministratore
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'.
                                '<ul>'.
                                    '<li tabindex="7"><a href="homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a></li>'.
                                    '<li tabindex="8"><a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a></li>'.
                                    '<li tabindex="9"><a href="messaggiAmministratore.php">MESSAGGI</a></li>'.
                                    '<li tabindex="10"><a href="veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a></li>'.
                                    '<li tabindex="11"><a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a></li>'.
                                '</ul>'.
                            '</div>';
            return $menuAmm_form;
        }

        private $connesssioneAmministratore='';

    #funzione per la connessione al database
        public function __construct() {
            $this->connessioneAmministratore = new database_connection();
        }
    
    #funzione per la lettura da database del nome dell'utente
        public function selectNomeUtente() {
            $identita = " "; #$identita = $_SESSION['email'];
            $query = 'SELECT Nome FROM Utenti WHERE Email=\''.$identita.'\'';
            $queryNomeUtente = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryNomeUtente)==0) {
                return null;
            } else{
                return $queryNomeUtente;
            }
        }
    
    #funzione per la lettura da database delle informazioni dell'utente
        public function selectInfoPersonali() {
            $identita = " ";
            $query = 'SELECT Email, Nome, Cognome, Telefono, Indirizzo, DataNascita FROM Utenti WHERE Email=\''.$identita.'\'';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryResult)==0) {
                return null;
            } else {
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
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryResult)==0) {
		        return null;
	        } else {
                $veicoliNoleggio = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $arrayVeicoloNoleggio = array('Targa'=>$row['Targa'],'Marca'=>$row['Marca'],'Modello'=>$row['Modello'],'Cilindrata'=>$row['Cilindrata'],'CostoNoleggio'=>$row['CostoNoleggio'],'Cauzione'=>$row['Cauzione']);
                    array_push($veicoliNoleggio,$arrayVeicoloNoleggio);
                }
                return $veicoliNoleggio;
            }
        }

    #funzione per la lettura da database dei veicoli in vendita
        public function selectVeicoliVendita() {
            $query = 'SELECT Marca, Modello, KM, Cilindrata, PrezzoVendita FROM AutoAutoVendita ORDER BY Marca GROUP BY Modello ASC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryResult)==0 ) {
		        return null;
	        } else {
                $veicoliVendita = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
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

    #funzione per la lettura dal database dei messaggi
        public function selectMessaggiRicevuti() {
            $query = 'SELECT Nome, Cognome, Email, NumeroTelefono, Messaggio FROM Messaggi ORDER BY IdMess DESC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryResult)==0) {
                return null;
            } else {
                $messaggi = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $singoloMessaggio = array('Nome'=>$row['Nome'],'Cognome'=>$row['Cognome'],'Email'=>$row['Email'],'NumeroTelefono'=>$row['NumeroTelefono'],'Messaggio'=>$row['Messaggio']);
                    array_push($messaggi,$singoloMessaggio);
                }
                return $messaggi;
            }
        }

        public function selectMessaggiInviati() {
            $identita = " "; #$identita = $_SESSION['email'];
            $query = 'SELECT EmailDestinatario, Oggetto, Messaggio FROM RisposteMessaggi WHERE Email=\''.$identita.'\' ORDER BY IdRisp DESC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if(mysqli_num_rows($queryResult)==0) {
                return null;
            } else {
                $messaggi = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $singoloMessaggio = array('EmailDestinatario'=>$row['EmailDestinatario'],'Oggetto'=>$row['Oggetto'],'Messaggio'=>$row['Messaggio']);
                    array_push($messaggi,$singoloMessaggio);
                }
                return $messaggi;
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
