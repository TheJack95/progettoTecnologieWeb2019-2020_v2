<?php
    require_once "../PHP/connessioneDB.php";
    require_once "../PHP/controlloInput.php";

    if (!isset($_SESSION))
        session_start();

    $errore = '';
	

    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $telefono = $_POST["numeroTelefono"];
    $messaggio = $_POST["messaggio"];
    
    

    if(controlloInput::validName($nome) && controlloInput::validName($cognome) && controlloInput::validEmail($email) && controlloInput::validPhone($telefono) && !empty($messaggio) ){
    
        $conn = new database_connection;
        if($conn->esegui("INSERT INTO Messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) VALUES ('$nome','$cognome','$email','$telefono','$messaggio')") == TRUE)
            $errore = "<p class=\"messaggio\" class=\"successMessage\"> Messaggio inserito con successo </p>";
        else
            $errore = "<p class=\"messaggio\" class=\"errorMessage\"> Si &egrave; verificato un errore di connessione, se il problema persiste riprova piu tardi. </p>"; 
    }
    else
        $errore = "<p class=\"messaggio\" class=\"errorMessage\"> Non &egrave; possibile procedere all&apos;invio del messaggio perch&egrave; non sono stati inseriti tutti i campi obbligatori in modo corretto. Ricorda che il campo telefono deve contenere un numero telefonico valido </p>";
    
    $_SESSION['response'] = $errore;
    
    header("location: ../PAGES/contatti.php#formMessaggio");



?>