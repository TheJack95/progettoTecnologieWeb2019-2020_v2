<?php
    require_once "backend/funzioni.php";
    require_once "backend/funzioniGiulia.php";

    $output = file_get_contents("../HTML/homeAmministratore.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Area Personale &gt;&gt; Homepage"),$output);
    $output = str_replace("<menuAmministratore></menuAmministratore>",funzioniGiulia::menuAmm(),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="../PHP/homeAmministratore.php"><span xml:lang="en">HOME</span> AREA PERSONALE</a>','<img class="iconaMenu" src="../Images/auto.svg" alt="icona del men&ugrave; che ritrae una automobilina" /><span xml:lang="en">HOME</span> AREA PERSONALE',$output);

    echo $output;
?>
