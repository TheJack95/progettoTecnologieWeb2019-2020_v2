<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    #AGGIUNGERE CONTROLLO SUL LOGIN

    $connessione = new funzioniAmministratore();
    $informazioni = "";

    if($connessione){
    #funzione lettura da database delle informazioni dell'utente
        $infoPersonali = $connessione->selectInfoPersonali();
        if($infoPersonali==null){
            $informazioni .= "non sono disponibili i tuoi dati personali, riprova pi&ugrave; tardi";
        } else{
            $informazioni .= $infoPersonali['Email']." ".$infoPersonali['Nome']." ".$infoPersonali['Cognome']." ".$infoPersonali['Telefono']." ".$infoPersonali['Indirizzo']." ".$infoPersonali['DataNascita']." .";
        }

    } else{
        $informazioni .= "Errore di connessione al database. Riprova pi&ugrave; tardi!";
    }

    $output = file_get_contents("../HTML/infoAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Informazioni Personali"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<infoPersonali></infoPersonali>",$informazioni,$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>INFORMAZIONI PERSONALI</strong>',$output);

    echo $output;
?>
