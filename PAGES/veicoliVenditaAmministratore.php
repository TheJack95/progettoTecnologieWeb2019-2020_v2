<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/funzioniAmministratore.php";
    require_once "../PHP/funzioniVeicoli.php";

    $output = file_get_contents("../HTML/veicoliVenditaAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Veicoli in vendita"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<veicoliVendita></veicoliVendita>",$veicoli,$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="veicoliVenditaAmministratore.php">VEICOLI IN VENDITA</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><strong>VEICOLI IN VENDITA</strong>',$output);

    echo $output;
?>
