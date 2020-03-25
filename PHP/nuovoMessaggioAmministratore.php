<?php
    require_once "backend/funzioni.php";
    require_once "backend/funzioniGiulia.php";

    $output = file_get_contents("../HTML/nuovoMessaggioAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Nuovo messaggio"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniGiulia::menuAmm(),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

    echo $output;
?>
