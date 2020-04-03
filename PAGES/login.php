<?php
require_once "../PHP/funzioniGenerali.php";

$output = file_get_contents("../HTML/login.html");
$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Accedi"),$output);

if(!isset($_SESSION))
    session_start();

if(isset($_SESSION["errmessage"])) {

    $errorMessage = $_SESSION["errmessage"];
    $output = str_replace("<loginError></loginError>","<p class='errorMessage'>$errorMessage</p>",$output);
    unset($_SESSION["errmessage"]);

}

echo $output;
?>