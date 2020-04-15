
<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/connesioneDB.php";

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Homepage"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="home.php"><span xml:lang="en" lang="en">HOME</span></a>','<strong>HOME</strong>',$output);

    /*$occasione = new database_connection;
    $sql = "SELECT column FROM AutoVendita ORDER BY RAND() LIMIT 1";
    $resultCheck = $occasione->esegui($sql);
    
    if($resultCheck == FALSE)
        $result = "<p class = \"erroMessage\">Non è possibile al momento possibile reperire l'occasione, riprova più tardi </p>"; 
    else{
        $row = mysqli_fetch_assoc($resultCheck);
        $result ="<div class=\"occasioneGiorno\">
                    <img src = ".$row->Immagine." alt = ".row->descrImmagine."

    }
    */
    echo $output;
?>
