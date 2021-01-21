<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('adozioni.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
$messIndex ='';

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $numGatti = $dbAccess->getNumAdottati();
    //$listaG = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    $messIndex = '<p> Già '. $numGatti . ' del rifugio hanno trovato una casa! Cosa aspetti?';



}

echo str_replace("<contatoreGatti />", $messIndex, $paginaHTML);

?>