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

    public function getAdmin($username, $password) {

        $query = "SELECT * FROM users WHERE username=$username AND pw=$password";
        $queryResult = mysqli_query($this->connection, $query);
        $rows = mysqli_num_rows($queryResult);
        return $rows;

    }

    public function inserisciVolontario($nome, $cognome, $dataNascita, $citta, $telefono, $volontario, $animali, $ore, $motivazione) {
        
        $queryInsV = " INSERT INTO volontari(nome, cognome, dataN, citta, telefono, volontario, animali, ore, motivo) VALUES (\"$nome\", \"$cognome\", \"$dataNascita\", \"$citta\", \"$telefono\", \"$volontario\", \"$animali\", \"$ore\", \"$motivazione\") ";
        
        mysqli_query($this->connection, $queryInsV);
        
        $righe = mysqli_affected_rows($this->connection);
        
        if ($righe > 0){
            return true;
        } else {
            return false;
        }
    }
    
    public function getListaVolontari() {

        $querySelect = "SELECT * FROM volontari ORDER BY ID ASC";
        $queryResult = mysqli_query($this->connection, $querySelect);
    
        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        } else {

            $listaVolontari = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {

                $singoloVolontario = array(

                    "ID" => $riga['ID'],
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

    public function inserisciGatto($nome, $genere, $adozione, $descrizione, $nomeImm) { // c'era anche alt imm

        $queryInsG = " INSERT INTO gatti(nome, genere, adozione, descrizione, nomeImmagine) VALUES (\"$nome\", \"$genere\", \"$adozione\", \"$descrizione\", \"$nomeImm\") ";

        mysqli_query($this->connection, $queryInsG);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }

    }

    public function getListaGatti() {

        $querySelect = " SELECT * FROM gatti ORDER BY ID ASC ";
        $queryResult = mysqli_query($this->connection, $querySelect);
    
        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        } else {

            $listaGat = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {

                $singoloGat = array(

                    "ID" => $riga['ID'],
                    "Nome" => $riga['nome'],
                    "Genere" => $riga['genere'],
                    "Adozione" => $riga['adozione'],
                    "Descrizione" => $riga['descrizione'],
                    "NomeImm" => $riga['nomeImmagine'],
                    "AltImm" => $riga['altImmagine']
                );

                array_push($listaGat, $singoloGat);
            }

            return $listaGat;
        }
    
    }

    public function getNumAdottati() {

        $queryCount = " SELECT COUNT(*) FROM gatti WHERE adozione=1 ";
        $queryResult = mysqli_query($this->connection, $queryCount);

        return $queryResult;
    }
    
    public function eliminaGatto($ID) {
        $queryElim = "DELETE FROM gatti WHERE ID=$ID";

        mysqli_query($this->connection, $queryElim);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }

    }

    public function eliminaVolontario($ID) {
        $queryElim = "DELETE FROM volontari WHERE ID=$ID";

        mysqli_query($this->connection, $queryElim);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }

    }

    public function modificaStatusAdottato($ID) {
        $queryMod = " UPDATE gatti SET adozione=1 WHERE ID=$ID ";

        mysqli_query($this->connection, $queryMod);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }


    }

    public function modificaStatusNonAdottato($ID) {
        $queryMod = " UPDATE gatti SET adozione=0 WHERE ID=$ID ";

        mysqli_query($this->connection, $queryMod);

        $righe = mysqli_affected_rows($this->connection);

        if ($righe > 0){
            return true;
        } else {
            return false;
        }

    }




    
} 



?>
