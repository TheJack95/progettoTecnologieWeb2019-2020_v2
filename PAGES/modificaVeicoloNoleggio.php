<?php
    require_once "../PHP/funzioni.php";
    require_once "../PHP/funzioniGiulia.php";

    $output = file_get_contents("../HTML/modificaVeicoloNoleggio.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Modifica veicolo a noleggio"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

    echo $output;
?>
