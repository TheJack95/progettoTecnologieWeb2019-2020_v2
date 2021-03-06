<?php
    require_once "../PHP/connessioneDB.php";

    class funzioniAmministratore {
    #funzione per il menu dell'area personale dell'amministratore
        public static function menuAmm() {
            $menuAmm_form = '<div id="menuAmministratore">'."\n".
                            '   <ul>'."\n".
                            '       <li><a href="homeAmministratore.php" tabindex="10"><span xml:lang="en" lang="en">Home</span> amministratore</a></li>'."\n".
                            '       <li><a href="infoAmministratore.php" tabindex="11">Informazioni personali</a></li>'."\n".
                            '       <li><a href="messaggiAmministratore.php" tabindex="12">Messaggi</a></li>'."\n".
                            '       <li><a href="veicoliNoleggioAmministratore.php" tabindex="13">Lista veicoli a noleggio</a></li>'."\n".
                            '       <li><a href="listaNoleggiAmministratore.php" tabindex="14">Prenotazioni veicoli</a></li>'."\n".
                            '       <li><a href="veicoliVenditaAmministratore.php" tabindex="15">Lista veicoli in vendita</a></li>'."\n".
                            '   </ul>'."\n".
                            '</div>';
            return $menuAmm_form;
        }

    #funzione per la connessione al database
        private $connesssioneAmministratore = '';

        public function __construct() {
            $this->connessioneAmministratore = new database_connection();
        }

    #funzione per la lettura da database del nome dell'utente
        public function selectNome() {
            $email = $_SESSION["user"];
            $query = 'SELECT Nome FROM Utenti WHERE Email=\''.$email.'\'';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
			    while($row=mysqli_fetch_assoc($queryResult)) {
                    $nome = (Object) ["Nome"=>$row['Nome']];
                    array_push($result,$nome);
                }
                return $result;
            }
        }
    
    #funzione per la lettura da database delle informazioni dell'utente
        public function selectInfoPersonali($email) {
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
            $query = 'SELECT IdAuto, Marca, Modello, KM, Cilindrata, PrezzoVendita, Immagine, DescrImmagine FROM AutoVendita GROUP BY Modello ORDER BY Marca ASC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
                while($row=mysqli_fetch_assoc($queryResult)) {
                    $veicoloV = (Object) [
                            "IdAuto"=>$row['IdAuto'],
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

    #funzione per la lettura da database del path dell'immagine da rimuovere
        public function selectImmagine($id, $table) {
            if($table == "noleggio") {
                $select = "SELECT Immagine FROM AutoNoleggio WHERE Targa='$id'";
            }
            if($table == "vendita") {
                $select = "SELECT Immagine FROM AutoVendita WHERE IdAuto='$id'";
            }
            $queryResult = $this->connessioneAmministratore->esegui($select);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
			    while($row=mysqli_fetch_assoc($queryResult)) {
                    $immagine = (Object) ["Immagine"=>$row['Immagine']];
                    array_push($result,$immagine);
                }
                return $result;
            }
        }
    
    #funzione per la lettura da database delle prenotazioni dei veicoli a noleggio
        public function selectPrenotazioniNoleggio() {
            $query = 'SELECT IdPrenot, Utente, Targa, InizioNoleggio, FineNoleggio FROM PrenotazioneNoleggio ORDER BY IdPrenot DESC';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
			    while($row=mysqli_fetch_assoc($queryResult)) {
                    $prenotazione = (Object) [
                                "IdPrenot"=>$row['IdPrenot'],
                                "Utente"=>$row['Utente'],
                                "Targa"=>$row['Targa'],
                                "InizioNoleggio"=>$row['InizioNoleggio'],
                                "FineNoleggio"=>$row['FineNoleggio']
                            ];
                    array_push($result,$prenotazione);
                }
                return $result;
            }
        }
    
    #funzione per la lettura da database delle informazioni sull'auto noleggiata
        public function selectAutoNoleggiata($targa) {
            $query = 'SELECT Marca, Modello, Immagine, DescrImmagine FROM AutoNoleggio WHERE Targa=\''.$targa.'\'';
            $queryResult = $this->connessioneAmministratore->esegui($query);
            $_POST = array();
            if($queryResult == false) {
                return [];
            } else {
                $result = array();
			    while($row=mysqli_fetch_assoc($queryResult)) {
                    $prenotazione = (Object) [
                                    "Marca"=>$row['Marca'],
                                    "Modello"=>$row['Modello'],
                                    "Immagine"=>$row['Immagine'],
                                    "DescrImmagine"=>$row['DescrImmagine']
                                ];
                    array_push($result,$prenotazione);
                }
                return $result;
            }
        }      
    }
?>