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
            if ($volontario['Volontario'] == 1) {
                $checkV = 'Ha gia fatto esperienze di volontariato';
            } else if ($volontario['Volontario'] == 0) {
                $checkV = 'Non ha mai fatto esperienze di volontariato';
            }

            $checkA = '';
            if ($volontario['Animali'] == 1) {
                $checkV = 'ha già avuto animali';
            } else if ($volontario['Animali'] == 0) {
                $checkV = 'non ha mai avuto animali';
            }

            $defVolontari .= '<dt>' . $volontario['Nome'] .' '. $volontario['Cognome'] . '</dt>';
            $defVolontari .= '<dd>';
            $defVolontari .= '<p>Nato il ' . $volontario['DataN'] . ' residente a ' . $volontario['Citta'] . ' numero di telefono: ' . $volontario['Telefono'] . '</p>';
            $defVolontari .= '<p>' . $checkV . ' e ' . $checkV . '. Può dedicare ' . $volontario['Ore'] . ' alla settimana al volontariato.</p>';
            $defVolontari .= '<q>' . $volontario['Motivo'] . '</q>';
            $defVolontari .= '</dd>';
        }

        $definitionListProtagonisti = $definitionListProtagonisti . "</dl>";

    }
    else {
        // messaggo che dice che non ci sono protagonisti nel DB
        $definitionListProtagonisti = "<p>Non ci sono volontari registrati</p>";
    }

    echo str_replace("<elencoVolontari />", $defVolontari, $paginaHTML);
}


?>