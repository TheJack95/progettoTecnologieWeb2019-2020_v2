<?php
    require_once "../PHP/funzioni.php";
    require_once "../PHP/funzioniGiulia.php";

    $output = file_get_contents("../HTML/infoAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Informazioni Personali"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniAmministratore::menuAmm(),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="infoAmministratore.php">INFORMAZIONI PERSONALI</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" />INFORMAZIONI PERSONALI',$output);

    echo $output;
?>
