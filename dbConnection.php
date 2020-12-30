<?php

namespace DB;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = "lscudele";
    private const PASSWORD = "suehaiHi6sie1fie";
    private const DATABASE_NAME = "lscudele";

    private $connection;

    public function openDBConnection() {

        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
        // ritorna false se non viene inserito correttamente altrimenti ritorna l'oggetto di tipo connessione

        if (!$this->connection) {
            return false;
        } else {
            return true;
        }
    
    }

    public function closeBDConnection() {

        $this->connection->close();
    }

    public function inserisciVolontario($nome, $cognome, $dataNascita, $citta, $telefono, $volontario, $animali, $ore, $motivazione) {
        
        $queryInserimento = "INSERT INTO volontari(Nome, Cognome, DataN, Citta, Telefono, Volontario, Animali, Ore, Motivo) VALUES (\"$nome\", \"$cognome\", \"$dataNascita\", \"$citta\", \"$telefono\", \"$volontario\", \"$animali\", \"$ore\", \"$motivazione\")";

        mysqli_query($this->connection, $queryInserimento);

        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        } else {
            return false;
        }
    }




    
} 



?>