<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";

    $output = file_get_contents("../HTML/modificaVeicoloVendita.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Modifica veicolo in vendita"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

    echo $output;
?>
