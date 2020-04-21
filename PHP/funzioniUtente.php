<?php
  require_once "../PHP/connessioneDB.php";

  class funzioniUtente {

    #connessione al database tramite costruttore
    public function __construct(){
        $this->dbConnection = new database_connection();
    }

    #estrazione dati utente
    public function getDati(){
        $emailUtente = $_SESSION["user"];
        $query = 'SELECT Email, Nome, Cognome, Telefono, Indirizzo, DataNascita FROM Utenti WHERE Email=\''.$emailUtente.'\'';
        $queryResult = $this->dbConnection->esegui($query);
        $contentItems = "";
        if(mysqli_num_rows($queryResult)==0){
          return null;
        } else{
          $row=mysqli_fetch_assoc($queryResult);
          $contentItems ="<div class='dati'>"."\n"
                        ."	<h2>I tuoi dati personali</h2>"."\n"
                        ."	<div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Nome:</span>"."\n"
                        ."			<span id='nome'>".$row['Nome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Cognome:</span>"."\n"
                        ."			<span id='cognome'>".$row['Cognome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Data di nascita:</span>"."\n"
                        ."			<span id='data'>".$row['DataNascita']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>E-mail:</span>"."\n"
                        ."			<span id='email'>".$row['Email']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Numero di telefono:</span>"."\n"
                        ."			<span id='telefono'>".$row['Telefono']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Indirizzo:</span>"."\n"
                        ."			<span id='email'>".$row['Indirizzo']."</span>"."\n"
                        ."		</div>"."\n"
                        ."	</div>"."\n"
                        ."</div>"."\n";
            }
            return $contentItems;
    }

    #estrazione preventivi
    public function getPreventivi(){
      $emailUtente = $_SESSION["user"];
      $query = 'SELECT IdPrev, Automobile, PrezzoVendita FROM PreventivoAcquisto WHERE Utente=\''.$emailUtente.'\'';
      $queryResult = $this->dbConnection->esegui($query);
      $contentItems = "";
      if(mysqli_num_rows($queryResult)==0){
        return "<h3>Non ci sono acquisti da visualizzare</h3>";
      } else{
        while($row=mysqli_fetch_assoc($queryResult)) {
          $queryAuto = 'SELECT Marca, Modello, KM, Cilindrata, Immagine, DescrImmagine FROM AutoVendita WHERE IdAuto=\''.$row['Automobile'].'\'';
          $connessioneAuto = new database_connection();
          $queryAutoResult = $connessioneAuto->esegui($queryAuto);
          $rowAuto=mysqli_fetch_assoc($queryAutoResult);
          $contentItems.='<div class="preventivi">'."\n"
          				      .'	<div>'."\n"
          							.'	<img class="immagini" src="'.$rowAuto['Immagine'].'" alt="'.$rowAuto['DescrImmagine'].'"/>'."\n"
          							.'		<p class="marcamodello">'.$rowAuto['Marca']." ".$rowAuto['Modello'].'</p>'."\n"
          							.'	</div>'."\n"
                        .'	<div>'."\n"
          							.'		<h4>Chilometraggio</h4>'."\n"
          							.'		<p>'.$rowAuto['KM'].'</p>'."\n"
          							.'	</div>'."\n"
          							.'	<div>'."\n"
          							.'		<h4>Prezzo</h4>'."\n"
          							.'		<p>'.$row['PrezzoVendita'].'</p>'."\n"
          							.'	</div>'."\n"
          							.'</div>';
        }
        return $contentItems;
      }
    }

    #estrazione noleggi
    public function getNoleggi(){
      $emailUtente = $_SESSION["user"];
      $query = 'SELECT IdPrenot, Targa, CostoTotale, InizioNoleggio, FineNoleggio FROM PrenotazioneNoleggio WHERE Utente=\''.$emailUtente.'\'';
      $queryResult = $this->dbConnection->esegui($query);
      $contentItems = "";
      if(mysqli_num_rows($queryResult)==0){
        return "<h3>Non ci sono noleggi da visualizzare</h3>";
      } else{
        while($row=mysqli_fetch_assoc($queryResult)) {
          $queryAuto = 'SELECT Marca, Modello, Cauzione, Cilindrata, Immagine, DescrImmagine FROM AutoNoleggio WHERE Targa=\''.$row['Targa'].'\'';
          $connessioneAuto = new database_connection();
          $queryAutoResult = $connessioneAuto->esegui($queryAuto);
          $rowAuto=mysqli_fetch_assoc($queryAutoResult);
					$contentItems.='<div class="noleggi">'."\n"
          				      .'	<div>'."\n"
                        .'	<img class="immagini" src="'.$rowAuto['Immagine'].'" alt="'.$rowAuto['DescrImmagine'].'"/>'."\n"
                        .'		<p class="marcamodello">'.$rowAuto['Marca']." ".$rowAuto['Modello'].'</p>'."\n"
                        .'		<h4>Targa</h4>'."\n"
          							.'		<p>'. $row['Targa'].'</p>'."\n"
          							.'	</div>'."\n"
          							.'	<div>'."\n"
          							.'		<h4>Costo totale</h4>'."\n"
          							.'		<p>'.$row['CostoTotale'].'</p>'."\n"
          							.'	</div>'."\n"
                        .'	<div>'."\n"
          							.'		<h4>Inizio noleggio</h4>'."\n"
          							.'		<p>'.$row['InizioNoleggio'].'</p>'."\n"
          							.'	</div>'."\n"
                        .'	<div>'."\n"
          							.'		<h4>Fine noleggio</h4>'."\n"
          							.'		<p>'.$row['FineNoleggio'].'</p>'."\n"
          							.'	</div>'."\n"
          							.'	<div>'."\n"
          							.'	</div>'."\n"
          							.'</div>';
        }
        return $contentItems;
      }
    }

    #estrazione messaggi
    public function getMessaggi(){
      $emailUtente = $_SESSION["user"];
      $query = 'SELECT Messaggio, IdMess FROM Messaggi WHERE Email=\''.$emailUtente.'\'';
      $queryResult = $this->dbConnection->esegui($query);
      $contentItems = "";
      if(mysqli_num_rows($queryResult)==0){
        return "<h3>Non ci sono messaggi da visualizzare</h3>";
      } else{
        while($row=mysqli_fetch_assoc($queryResult)) {
					$contentItems.='<div class="messaggi">'."\n"
                        .'	<div class="testoMessaggio">'."\n"
                        .'		<h4>Messaggio N° '.$row['IdMess'].'</h4>'."\n"
                        .'		<p>'.$row['Messaggio'].'</p>'."\n"
                        .'	</div>'."\n"
                        .'</div>';
        }
        return $contentItems;
      }
    }



  }
