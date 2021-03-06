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
        $contentItems = '<h3 class="titolo">I MIEI DATI</h3>'."\n";
        if(mysqli_num_rows($queryResult)==0){
          return null;
        } else{
          $row=mysqli_fetch_assoc($queryResult);
          $contentItems.="<div class='dati'>"."\n"
                        ."	<div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Nome&#58;</span>"."\n"
                        ."			<span>".$row['Nome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Cognome&#58;</span>"."\n"
                        ."			<span>".$row['Cognome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Data di nascita&#58;</span>"."\n"
                        ."			<span>".$row['DataNascita']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>E-mail&#58;</span>"."\n"
                        ."			<span>".$row['Email']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Numero di telefono&#58;</span>"."\n"
                        ."			<span>".$row['Telefono']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Indirizzo&#58;</span>"."\n"
                        ."			<span>".$row['Indirizzo']."</span>"."\n"
                        ."		</div>"."\n"
                        ."	</div>"."\n"
                        ."  <a class='linkRapidi' href='areaPrivata.php?pageName=setDatiPersonali'>Modifica</a>"."\n"
                        ."</div>"."\n";
            }
            return $contentItems;
    }

    #modifica dati utente
    public function setDati(){
        $emailUtente = $_SESSION["user"];
        $query = 'SELECT Email, Nome, Cognome, Telefono, Indirizzo, DataNascita FROM Utenti WHERE Email=\''.$emailUtente.'\'';
        $queryResult = $this->dbConnection->esegui($query);
        $contentItems = '<h3 class="titolo">MODIFICA I TUOI DATI</h3>'."\n";
        if(mysqli_num_rows($queryResult)==0){
          return null;
        } else{
          $row=mysqli_fetch_assoc($queryResult);
          $contentItems.="<div class='dati'>"."\n"
                        ." <form id='setDati' onsubmit='return checkForm(".'"setDati"'.");' action='../PHP/setDatiUtente.php' method='post'>"."\n"
                        ."  <fieldset>"."\n"
                        ."	 <div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Nome&#58;</span>"."\n"
                        ."			<span>".$row['Nome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<label for='nome'>Nuovo nome&#58;</label>"."\n"
                        ."			<input type='text' name='nome' id='nome' />"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Cognome&#58;</span>"."\n"
                        ."			<span>".$row['Cognome']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<label for='cognome'>Nuovo cognome&#58;</label>"."\n"
                        ."			<input type='text' name='cognome' id='cognome' />"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Data di nascita&#58;</span>"."\n"
                        ."			<span>".$row['DataNascita']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<label for='nascita'>Nuova data di nascita&#58;</label>"."\n"
                        ."			<input type='text' name='nascita' id='nascita' />"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Numero di telefono&#58;</span>"."\n"
                        ."			<span>".$row['Telefono']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<label for='telefono'>Nuovo numero di telefono&#58;</label>"."\n"
                        ."			<input type='text' name='telefono' id='telefono' />"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<span>Indirizzo&#58;</span>"."\n"
                        ."			<span id='email'>".$row['Indirizzo']."</span>"."\n"
                        ."		</div>"."\n"
                        ."		<div>"."\n"
                        ."			<label for='indirizzo'>Nuovo indirizzo&#58;</label>"."\n"
                        ."			<input type='text' name='indirizzo' id='indirizzo' />"."\n"
                        ."		</div>"."\n"
                        ."    <input type='submit' class='bottoni' value='Salva modifiche'/>"
                        ."	 </div>"."\n"
                        ."  </fieldset>"."\n"
                        ." </form>"."\n"
                        ."</div>"."\n";
            }
            return $contentItems;
    }

    #estrazione preventivi
    public function getPreventivi(){
      $emailUtente = $_SESSION["user"];
      $query = 'SELECT IdPrev, Automobile, PrezzoVendita FROM PreventivoAcquisto WHERE Utente=\''.$emailUtente.'\'';
      $queryResult = $this->dbConnection->esegui($query);
      $contentItems = '<h3 class="titolo">I MIEI PREVENTIVI</h3>'."\n";
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
          							.'		<p>'.$rowAuto['KM'].' km</p>'."\n"
          							.'	</div>'."\n"
          							.'	<div>'."\n"
          							.'		<h4>Prezzo</h4>'."\n"
          							.'		<p>'.$row['PrezzoVendita'].' &euro;</p>'."\n"
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
      $contentItems = '<h3 class="titolo">I MIEI NOLEGGI</h3>'."\n";
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
          							.'		<p>'.$row['CostoTotale'].' &euro;</p>'."\n"
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
      $contentItems = '<h3 class="titolo">I MIEI MESSAGGI</h3>'."\n";
      if(mysqli_num_rows($queryResult)==0){
        return "<h3>Non ci sono messaggi da visualizzare</h3>";
      } else{
        while($row=mysqli_fetch_assoc($queryResult)) {
          $queryMessaggi = 'SELECT Messaggio, IdRisp, Oggetto FROM RisposteMessaggi WHERE Destinatario=\''.$row['IdMess'].'\'';
          $connessioneMessaggi = new database_connection();
          $risposteResult = $connessioneMessaggi->esegui($queryMessaggi);
          $rowMessaggi =mysqli_fetch_assoc($risposteResult);
          if(mysqli_num_rows($risposteResult)==0){
            $contentItems.='<div class="messaggi">'."\n"
                          .'	<div class="testoMessaggio">'."\n"
                          .'		<h4>Messaggio N° '.$row['IdMess'].'</h4>'."\n"
                          .'		<p>'.$row['Messaggio'].'</p>'."\n"
                          .'	</div>'."\n"
                          .'</div>';
          } else{
            $contentItems.='<div class="messaggi">'."\n"
                          .'	<div class="testoMessaggio">'."\n"
                          .'		<h4>Messaggio N° '.$row['IdMess'].'</h4>'."\n"
                          .'		<p>'.$row['Messaggio'].'</p>'."\n"
                          .'	</div>'."\n"
                          .'	<div class="testoMessaggio">'."\n"
                          .'		<h4>Risposta dell&apos;amministratore </h4>'."\n"
                          .'    <div>Oggetto&#58; '.$rowMessaggi['Oggetto'].'</div>'."\n"
                          .'		<p>'.$rowMessaggi['Messaggio'].'</p>'."\n"
                          .'	</div>'."\n"
                          .'</div>';
          }
        }
        return $contentItems;
      }
    }



  }
