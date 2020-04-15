<?php
    require_once "../PHP/connessioneDB.php";

    class funzioniAmministratore {
    #funzione per il menu dell'area personale dell'amministratore
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'."\n".
                            '   <ul>'."\n".
                            '       <li tabindex="7"><a href="homeAmministratore.php"><span xml:lang="en">HOME</span> AMMINISTRATORE</a></li>'."\n".
                            '       <li tabindex="8"><a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a></li>'."\n".
                            '       <li tabindex="9"><a href="messaggiAmministratore.php">MESSAGGI</a></li>'."\n".
                            '       <li tabindex="10"><a href="veicoliNoleggioAmministratore.php">VEICOLI A NOLEGGIO</a></li>'."\n".
                            '       <li tabindex="11"><a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a></li>'."\n".
                            '   </ul>'."\n".
                            '</div>';
            return $menuAmm_form;
        }

    #funzione per la connessione al database
        private $connesssioneAmministratore = '';

        public function __construct() {
            $this->connessioneAmministratore = new database_connection();
        }
    
    #funzione per la lettura da database delle informazioni dell'utente
        public function selectInfoPersonali() {
            $email = $_SESSION["user"];
            $query = 'SELECT Email, Nome, Cognome, Telefono, Indirizzo, DataNascita FROM Utenti WHERE Email=\''.$email.'\'';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
			    while($row=mysqli_fetch_assoc($queryResult)) {
                    $infoPersonali = (Object) [
                                "Email"=>$row['Email'],
                                "Nome"=>$row['Nome'],
                                "Cognome"=>$row['Cognome'],
                                "Telefono"=>$row['Telefono'],
                                "Indirizzo"=>$row['Indirizzo'],
                                "DataNascita"=>$row['DataNascita']
                            ];
                    array_push($result,$infoPersonali);
                }
                return $result;
            }
        }

    #funzione per la lettura dal database dei messaggi ricevuti
        public function selectMessaggiRicevuti() {
            $query = 'SELECT IdMess, Nome, Cognome, Email, NumeroTelefono, Messaggio FROM Messaggi ORDER BY IdMess DESC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $messRicevuti = (Object) [
                                "IdMess"=>$row['IdMess'],
                                "Nome"=>$row['Nome'],
                                "Cognome"=>$row['Cognome'],
                                "Email"=>$row['Email'],
                                "NumeroTelefono"=>$row['NumeroTelefono'],
                                "Messaggio"=>$row['Messaggio']
                            ];
                    array_push($result,$messRicevuti);
                }
                return $result;
            }
        }

    #funzione per la lettura dal database dei messaggi inviati
        public function selectMessaggiInviati($destinatario) {
            $query = 'SELECT Oggetto, Messaggio FROM RisposteMessaggi WHERE Destinatario=\''.$destinatario.'\'';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $messInviati = (Object) [
                                "Oggetto"=>$row['Oggetto'],
                                "Messaggio"=>$row['Messaggio']
                            ];
                    array_push($result,$messInviati);
                }
                return $result;
            }
        }

    #funzione per la lettura da database dei veicoli a noleggio
        public function selectVeicoliNoleggio() {
            $query = 'SELECT Targa, Marca, Modello, Cilindrata, CostoNoleggio, Cauzione, Immagine, DescrImmagine FROM AutoNoleggio GROUP BY Modello ORDER BY Marca ASC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $veicoloN = (Object) [
                            "Targa"=>$row['Targa'],
                            "Marca"=>$row['Marca'],
                            "Modello"=>$row['Modello'],
                            "Cilindrata"=>$row['Cilindrata'],
                            "CostoNoleggio"=>$row['CostoNoleggio'],
                            "Cauzione"=>$row['Cauzione'],
                            "Immagine"=>$row['Immagine'],
                            "DescrImmagine"=>$row['DescrImmagine']
                    ];
                    array_push($result,$veicoloN);
                }
                return $result;
            }
        }

    #funzione per la lettura da database dei veicoli in vendita
        public function selectVeicoliVendita() {
            $query = 'SELECT Marca, Modello, KM, Cilindrata, PrezzoVendita, Immagine, DescrImmagine FROM AutoVendita GROUP BY Modello ORDER BY Marca ASC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $veicoloV = (Object) [
                            "Marca"=>$row['Marca'],
                            "Modello"=>$row['Modello'],
                            "KM"=>$row['KM'],
                            "Cilindrata"=>$row['Cilindrata'],
                            "PrezzoVendita"=>$row['PrezzoVendita'],
                            "Immagine"=>$row['Immagine'],
                            "DescrImmagine"=>$row['DescrImmagine']
                    ];
                    array_push($result,$veicoloV);
                }
                return $result;
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
            $marca = $_POST['marca'];
            $modello = $_POST['modello'];
            $km = $_POST['km'];
            $cilindrata = $_POST['cilindrata'];
            $prezzoVendita = $_POST['prezzoVendita'];
            
            $insertVeicoloVendita = "INSERT INTO AutoVendita() VALUES ('','$marca','$modello','$km','$cilindrata','$prezzoVendita')";
            if($this->connection->query($insertVeicoloVendita) === TRUE){
                return true;
            } else{
                return false;
            }
        }


        
    }
?>
