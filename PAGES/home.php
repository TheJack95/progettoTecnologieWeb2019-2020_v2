
<?php
    require_once "../PHP/funzioniGenerali.php";
    require_once "../PHP/connessioneDB.php";

    $output = file_get_contents("../HTML/home.html");
    $output = str_replace("<header></header>",funzioniGenerali::header(),$output);
    $output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
    $output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Homepage"),$output);
    $output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
    $output = str_replace('<a href="home.php"><img class="logoHeader" src="../Images/LogoGREG.png" alt="logo concessionaria greg" /></a>','<img class="logoHeader" src="../Images/LogoGREG.png" alt="logo concessionaria greg" />',$output);
    $output = str_replace('<p class="nomeSito"><a href="home.php">CONCESSIONARIA GREG</a></p>','<p class="nomeSito">CONCESSIONARIA GREG</p>',$output);
    $output = str_replace('<a href="home.php" tabindex="3"><span xml:lang="en" lang="en">HOME</span></a>','<strong>HOME</strong>',$output);

    $occasione = new database_connection;
    $seed = date('Ymd');
    $sql = "SELECT * FROM AutoVendita ORDER BY RAND($seed) LIMIT 1";
    $resultCheck = $occasione->esegui($sql);

    if($resultCheck == false || mysqli_num_rows($resultCheck) == 0)
        $result = "<p class = \"erroMessage\">Non è possibile al momento possibile reperire l'occasione, riprova più tardi </p>";
    else{
        $row = mysqli_fetch_assoc($resultCheck);
        $sconto = $row['PrezzoVendita']*20/100;
        $prezzoOccasione=$row['PrezzoVendita']-$sconto;
        $result = 
                   "<div id = \"occasioneGiorno\">
                        <p class=\"titolo\">OCCASIONE DEL GIORNO</p>
                        <img id = \"auto\" src = '".$row['Immagine']."' alt = '".$row['DescrImmagine']."'></img>
                        <div id = \"contentOccasione\">
                            
                            <p class = \"titoloOccasione\">20% DI SCONTO SU:</p>
                            <p class = \"titoloOccasione\"> " .$row['Marca']. " " .$row['Modello']. "</p>
                            <p class = \"prezzo\"> PREZZO ORIGINALE: " .$row["PrezzoVendita"]. "&#8364;</p>
                            <p class = \"prezzo\"> PREZZO OCCASIONE: " .$prezzoOccasione. "&#8364;</p>
                            <a class=\"linkMod hidePrint\" href=\"../PHP/acquistaVeicoloFn.php?idAuto=".$row['IdAuto']."\">Richiedi preventivo</a>
                        </div> 
                    </div>";
        }
    
    $output = str_replace('<occasione></occasione>',$result,$output);
    
    echo $output;
?>
