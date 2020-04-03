<?php
require_once "../PHP/modulesInit.php";
require_once "../PHP/config/config.php";

if(!isset($_SESSION))
	session_start();

$output = file_get_contents("../HTML/paginaVuota.html");
$output = str_replace("<header></header>",funzioniGenerali::header(),$output);

$output = str_replace("<menu></menu>",funzioniGenerali::menu(),$output);

$output = str_replace("<breadcrumb></breadcrumb>",funzioniGenerali::breadcrumb("Noleggio del veicolo"),$output);

$output = str_replace("<footer></footer>",funzioniGenerali::footer(),$output);

if(isset($_SESSION["messagge"])) {
	$mess = $_SESSION["messagge"];
	$output = str_replace("<messaggio></messaggio>","<p class='messaggio'>$mess</p>",$output);
	unset($_SESSION["messagge"]);
}

echo $output;

if(isset($_SESSION["redirect"])){
	if($_SESSION["redirect"] == "login"){
		header("refresh:5; url= ./login.php");
	}
} else{
	header("refresh:5; url= ./home.php");
}
?>