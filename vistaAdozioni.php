<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('adozioni.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
    // si chiude senza dare una risposta all'utente fare un try catch
} else {
    $listaG = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    //definizione lista di gatti
    $defGatti = "";

    if ($listaG != null) {
       
        $defGatti = '<dl class="schede"><span>';

        foreach ($listaG as $gatto) {

            $checkGenere = '';
            if ($gatto['Genere'] == 1) {
                $checkGenere = 'Femmina';
            } else if ($gatto['Genere'] == 0) {
                $checkGenere = 'Maschio';
            }

            $defGatti .= '<dt>'. $gatto['Nome'] . '</dt>';
            $defGatti .= '<dd>';
            $defGatti .= '<img src="immagini'. DIRECTORY_SEPARATOR. 'gatti'. DIRECTORY_SEPARATOR. $gatto['NomeImm'] . '" alt="' . $gatto['AltImm'] . '" />';
            $defGatti .= '<p>' . $checkGenere . '</p>';
            $defGatti .= '<p>' . $gatto['Descrizione'] . '</p>';
            $defGatti .= '</dd>';
            
        }

        $defGatti = $defGatti . "</span></dl>";

    }
    else {
       
        $defGatti = "<p>Non ci sono gatti al momento</p>";
    }

    echo str_replace("<elencoGatti />", $defGatti, $paginaHTML);
}


?>