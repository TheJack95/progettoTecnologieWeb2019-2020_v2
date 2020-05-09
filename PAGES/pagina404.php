<?php

    require_once "../PHP/funzioniGenerali.php";

    $output = file_get_contents("../HTML/pagina404.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Pagina 404"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

    echo $output;
?>
