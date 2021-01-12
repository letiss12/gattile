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

    public function closeDBConnection() {

        $this->connection->close();
    }

    public function inserisciVolontario($nome, $cognome, $dataNascita, $citta, $telefono, $volontario, $animali, $ore, $motivazione) {
        
        $queryInserimento = "INSERT INTO volontari(nome, cognome, dataN, citta, telefono, volontario, animali, ore, motivo) VALUES (\"$nome\", \"$cognome\", \"$dataNascita\", \"$citta\", \"$telefono\", \"$volontario\", \"$animali\", \"$ore\", \"$motivazione\")";

        mysqli_query($this->connection, $queryInserimento);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }
    }
    
    public function getListaVolontari() {

        $querySelect = "SELECT * FROM volontari ORDER BY Nome ASC";
        $queryResult = mysqli_query($this->connection, $querySelect);
    
        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        } else {

            $listaVolontari = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {

                $singoloVolontario = array(

                    "Nome" => $riga['nome'],   
                    "Cognome" => $riga['cognome'],
                    "DataNascita" => $riga['dataN'],
                    "Citta" => $riga['citta'],
                    "Telefono" => $riga['telefono'],
                    "Volontariato" => $riga['volontario'],
                    "Animali" => $riga['animali'],
                    "Ore" => $riga['ore'],
                    "Motivazione" => $riga['motivo'],

                );

                array_push($listaVolontari, $singoloVolontario);
            }

            return $listaVolontari;
        }
    
    }




    
} 



?>
