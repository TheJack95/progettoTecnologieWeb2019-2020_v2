<?php
class database_connection {
    private const HOST = 'localhost';
    private const USERNAME = 'admin';
    private const PASSWORD = 'admin';
    private const DATABASE_NAME = 'concessionaria';
    private $connessione;

    public function __construct() {
        if (!($this->connessione = @mysqli_connect(static::HOST, static::USERNAME, static::PASSWORD, static::DATABASE_NAME))) {
            error_log("Debugging errno: " . mysqli_connect_errno()."Debugging error: " . mysqli_connect_error());
            echo "Momentaneamente i dati non sono disponibili. Riprovare più tardi.";
        }
    }

    public function getConnessione() { 
        return $this->getConnessione;
    }

    public function esegui($query) {
        $result = mysqli_query($this->connessione, $query);
        if($result == false)
            $result = '<p class=\"errore\"> Si è verificato un errore di connessione, se il problema persiste riprova piu tardi. </p>'; 
        mysqli_close($this->connessione);
        return $result;
    }

    public function chiudiConnessione() {
        mysqli_close($this->connessione);
    }
}
?>
