<?php
    require_once "../PHP/funzioni.php";
    require_once "../PHP/funzioniGiulia.php";

    #AGGIUNGERE CONTROLLO SUL LOGIN

    $oggettoPagina = new funzioniAmministratore();
    $connessione = $oggettoPagina->apriConnessioneDB();

    if($connessione){
    #funzione lettura da SESSION identita' dell'utente
        $nome = $oggettoPagina->selectNomeUtente();
    } else{
        $nome = "non è disponibile il tuo nome in questo momento";
    }
    
    $output = file_get_contents("../HTML/homeAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Homepage"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<nome></nome>",$nome,$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><span xml:lang="en">HOME</span> AREA PERSONALE',$output);

    echo $output;
?>
