<?php
require_once "../PHP/funzioniGenerali.php";

$output = file_get_contents("../HTML/login.html");
$output = str_replace("<header></header>",funzioniGenerali::header(),$output);
$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Accedi"),$output);
$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);
$output = str_replace('<a class="" href="login.php">ACCEDI</a>','<strong>ACCEDI</strong>',$output);

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION["errmessage"])) {

    $errorMessage = $_SESSION["errmessage"];
    $output = str_replace("<loginError></loginError>","<p class='errorMessage'>$errorMessage</p>",$output);
    unset($_SESSION["errmessage"]);
} elseif(isset($_SESSION["successmessage"])) {

    $errorMessage = $_SESSION["successmessage"];
    $output = str_replace("<loginError></loginError>","<p class='successMessage'>$errorMessage</p>",$output);
    unset($_SESSION["successmessage"]);
} else {
    $output = str_replace("<loginError></loginError>","<p></p>",$output);
}

echo $output;
?>
