
<?php
    require_once "../PHP/funzioniGenerali.php";

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Homepage"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="home.php"><span xml:lang="en" lang="en">HOME</span></a>','<strong>HOME</strong>',$output);

    echo $output;
?>
