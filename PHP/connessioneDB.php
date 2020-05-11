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
            echo "Momentaneamente i dati non sono disponibili. Riprovare pi&ugrave; tardi.";
        }
    }

    public function getConnessione() { 
        return $this->getConnessione;
    }

    public function esegui($query, $chiudiConn = true) {
        if($this->connessione) {
            $result = mysqli_query($this->connessione, $query); // or die("Invalid query: " . mysqli_error($this->connessione));
            //echo var_dump($result);
            if($chiudiConn)
                mysqli_close($this->connessione);
            return $result;
        } else {
            echo "Errore nella connessione con il database. Riprovare pi&ugrave; tardi.";
        }

    }

    public function chiudiConnessione() {
        mysqli_close($this->connessione);
    }
}
?>
