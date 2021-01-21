<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('elencoGatti.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $listaG = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    $defGatti = "";

    if ($listaG != null) {
        
        $defGatti = '<h3>Gatti che cercano ancora una casa</h3><dl>';
        foreach ($listaG as $gatto) {
            if ($gatto['Adozione'] == 0) {
                $checkGenere = '';
                if ($gatto['Genere'] == 1) {
                    $checkGenere = 'Femmina';
                } else if ($gatto['Genere'] == 0) {
                    $checkGenere = 'Maschio';
                }

                $defGatti .= '<span><dt>'. $gatto['Nome'] . ' - '. $checkGenere . '</dt>';
                $defGatti .= '<dd><img src="immagini'. DIRECTORY_SEPARATOR. 'gatti'. DIRECTORY_SEPARATOR. $gatto['NomeImm'] . '" alt="' . $gatto['AltImm'] . '" /></dd></span>';
            }      
        }
        $defGatti .= '</dl><h3>Gatti che sono già stati adottati</h3><dl>';
        foreach ($listaG as $gatto) {

            if ($gatto['Adozione'] == 1) {
                $checkGenere = '';
                if ($gatto['Genere'] == 1) {
                    $checkGenere = 'Femmina';
                } else if ($gatto['Genere'] == 0) {
                    $checkGenere = 'Maschio';
                }

                $defGatti .= '<span><dt>'. $gatto['Nome'] . ' - '. $checkGenere . '</dt>';
                $defGatti .= '<dd><img src="immagini'. DIRECTORY_SEPARATOR. 'gatti'. DIRECTORY_SEPARATOR. $gatto['NomeImm'] . '" alt="' . $gatto['AltImm'] . '" /></dd></span>';

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