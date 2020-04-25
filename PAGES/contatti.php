
<?php
    require_once "../PHP/funzioniGenerali.php";
    
    $output = file_get_contents("../HTML/contatti.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Contatti"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="contatti.php" tabindex="4">CONTATTI</a>','<strong>CONTATTI</strong>',$output);

    if(isset($_SESSION['response'])){
        $output = str_replace('<messaggio></messaggio>',$_SESSION['response'],$output);
        unset($_SESSION['response']);
    }

    echo $output;
?>
