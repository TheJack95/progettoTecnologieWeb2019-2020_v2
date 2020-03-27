<?php
    require_once "../PHP/connessioneDB.php";

    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $telefono = $_POST["numeroTelefono"];
    $messaggio = $_POST["messaggio"];


    $conn = new database_connection;
    if($conn->esegui("INSERT INTO Messaggi (Nome,Cognome,Email,NumeroTelefono,Messaggio) VALUES ('$nome','$cognome','$email','$telefono','$messaggio')") == TRUE)
    echo 'Messaggio inserito con successo';
    else
    echo 'Si è verificato un errore durante l inserimento del messaggio'; 






?>