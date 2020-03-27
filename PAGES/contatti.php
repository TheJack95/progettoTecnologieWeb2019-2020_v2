
<?php
    require_once "../PHP/funzioni.php";
    
    $output = file_get_contents("../HTML/contatti.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Contatti"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="contatti.php">CONTATTI</a>','<strong>CONTATTI</strong>',$output);

    echo $output;
?>
