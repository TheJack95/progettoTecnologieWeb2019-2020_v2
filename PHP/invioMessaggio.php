<?php
    require_once "../PHP/connessioneDB.php";
    require_once "../PHP/controlloInput.php";

    if (!isset($_SESSION))
        session_start();

    $response = '';
	

    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $telefono = $_POST["numeroTelefono"];
    $messaggio = $_POST["messaggio"];
    
    

    if(controlloInput::validName($nome) && controlloInput::validName($cognome) && controlloInput::validEmail($email) && (controlloInput::validPhone($telefono) || empty($telefono)) && !empty($messaggio) ){
    
        $conn = new database_connection;
        if($conn->esegui("INSERT INTO Messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) VALUES ('$nome','$cognome','$email','$telefono','$messaggio')") == TRUE)
            $response = '<p class=\"successo\">Messaggio inserito con successo</p>';
        else
            $response = '<p class=\"errore\"> Si è verificato un errore durante l inserimento del messaggio, se il problema persiste riprova piu tardi. </p>'; 
    }
    else
        $response = '<p class=\"errore\"> Non &egrave; possibile procedere all&apos;invio del messaggio perch&egrave; non sono stati inseriti tutti i cambi obbligatori in modo corretto o il numero di telefono inserito non &egrave; valido. Ricorda che il campo telefono deve contenere un numero telefonico valido o essere vuoto </p>';
    
    $_SESSION['response'] = $response;
    
    header("location: ../PAGES/contatti.php#formMessaggio");



?>