<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('home.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $listaG = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();
    $messIndex ='';

    if ($listaG != null) {

        $messIndex = '<p>Questi bellissimi gatti hanno già trovato una casa! Tu cosa aspetti?</p><dl>';
        foreach ($listaG as $gatto) {
            if ($gatto['Adozione'] == 1) {
                $messIndex .= '<dt>'. $gatto['Nome'] .'</dt>';
                $messIndex .= '<dd><img src="immagini'. DIRECTORY_SEPARATOR. 'gatti'. DIRECTORY_SEPARATOR. $gatto['NomeImm'] . '" alt="' . $gatto['AltImm'] . '" /></dd>';
            }
            $messIndex .= '</dl>';

        }
    }

    str_replace("<contatoreGatti />", $messIndex, $paginaHTML);
   
}


echo $paginaHTML;

?>