<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";
    
    #AGGIUNGERE CONTROLLO SUL LOGIN

    $connessione = new funzioniAmministratore();
    $ricevuti = "";
    $inviati = "";

    if($connessione){
    #funzione lettura da database dei messaggi ricevuti
        $mesRicevuti = $connessione->selectMessaggiRicevuti();
        if($mesRicevuti == null) {
            $ricevuti .= "non sono disponibili i tuoi messaggi ricevuti, riprova pi&ugrave; tardi";
        } else {
            foreach($mesRicevuti as $row) {
                $ricevuti .= "Mittente: ".$row['Nome']." ".$row['Cognome']."<br />Email: ".$row['Email']."<br />NumeroTelefono: ".$row['NumeroTelefono']."<br />Messaggio: ".$row['Messaggio']."<br />";
            }
        }
    #funzione lettura da database dei messaggi inviati
        $mesInviati = $connessione->selectMessaggiInviati();
        if($mesInviati == null) {
            $inviati .= "non sono disponibili i tuoi messaggi inviati, riprova pi&ugrave; tardi";
        } else {
            foreach($mesInviati as $row) {
                $inviati .= "Destinatario: ".$row['Destinatario']."<br />Oggetto: ".$row['Oggetto']."<br />Messaggio: ".$row['Messaggio']."<br />";
            }
        }
    } else {
        $ricevuti .= "Errore di connessione al database. Riprova pi&ugrave; tardi!";
        $inviati .= "Errore di connessione al database. Riprova pi&ugrave; tardi!";
    }

    $output = file_get_contents("../HTML/messaggiAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Messaggi"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<messaggiRicevuti></messaggiRicevuti>",$ricevuti,$output);
    $output = str_replace("<messaggiInviati></messaggiInviati>",$inviati,$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="messaggiAmministratore.php">MESSAGGI</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>MESSAGGI</strong>',$output);

    echo $output;
?>
