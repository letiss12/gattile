<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('adozioni.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $listaG = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    $defGatti = "";

    if ($listaG != null) {
       
        $defGatti = '<dl>';

        foreach ($listaG as $gatto) {

            if ($gatto['Adozione'] == 0) {
                $checkGenere = '';
                if ($gatto['Genere'] == 1) {
                    $checkGenere = 'Femmina';
                } else if ($gatto['Genere'] == 0) {
                    $checkGenere = 'Maschio';
                }

                $defGatti .= '<span><dt>'. $gatto['Nome'] . '</dt>';
                $defGatti .= '<dd>';
                $defGatti .= '<img src="immagini'. DIRECTORY_SEPARATOR. 'gatti'. DIRECTORY_SEPARATOR. $gatto['NomeImm'] . '" alt="' . $gatto['AltImm'] . '" />';
                $defGatti .= '<p>' . $checkGenere . '</p>';
                $defGatti .= '<p>' . $gatto['Descrizione'] . '</p>';
                $defGatti .= '</dd></span>';
            }    
            
        }

        $defGatti = $defGatti . "</dl>";

    }
    else {
       
        $defGatti = "<p>Non ci sono gatti al momento</p>";
    }

    echo str_replace("<elencoGatti />", $defGatti, $paginaHTML);
}


?>