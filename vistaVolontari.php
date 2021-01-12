<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('elencoVolontari.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
    // si chiude senza dare una risposta all'utente fare un try catch
} else {
    $listaVolontari = $dbAccess->getListaVolontari();
    $dbAccess->closeDBConnection();

    $defVolontari = "";

    if ($listaVolontari != null) {
        // creo parte pg html con elenco dei personaggi
        $defVolontari = '<dl id="descrizioneVolontari">';

        foreach ($listaVolontari as $volontario) {

            $checkV = '';
            if ($volontario['volontario'] == 1) {
                $checkV = 'Ha gia fatto esperienze di volontariato';
            } else if ($volontario['volontario'] == 0) {
                $checkV = 'Non ha mai fatto esperienze di volontariato';
            }

            $checkA = '';
            if ($volontario['animali'] == 1) {
                $checkA = 'ha già avuto animali';
            } else if ($volontario['animali'] == 0) {
                $checkA = 'non ha mai avuto animali';
            }

            $defVolontari .= '<dt>' . $volontario['nome'] .' '. $volontario['cognome'] . '</dt>';
            $defVolontari .= '<dd>';
            $defVolontari .= '<p>Nato il ' . $volontario['dataN'] . ' residente a ' . $volontario['citta'] . ' numero di telefono: ' . $volontario['telefono'] . '</p>';
            $defVolontari .= '<p>' . $checkV . ' e ' . $checkA . '. Può dedicare ' . $volontario['ore'] . ' alla settimana al volontariato.</p>';
            $defVolontari .= '<q>' . $volontario['motivo'] . '</q>';
            $defVolontari .= '</dd>';
        }

        $defVolontari = $defVolontari . "</dl>";

    }
    else {
        // messaggo che dice che non ci sono protagonisti nel DB
        $defVolontari = "<p>Non ci sono volontari registrati</p>";
    }

    echo str_replace("<elencoVolontari />", $defVolontari, $paginaHTML);
}


?>