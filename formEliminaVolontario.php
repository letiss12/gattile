<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('eliminaVolontario.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
    // si chiude senza dare una risposta all'utente fare un try catch
} else {
    $listaVol = $dbAccess->getListaVolontari();
    $dbAccess->closeDBConnection();

    $defForm = '';
    if ($listaVol != null) {

        $defForm = '<fieldset>';

        foreach ($listaVol as $vol) {
            $ID = $vol['ID'];
            $nome = $vol['Nome'];
            $cognome = $vol['Cognome'];
            $defForm .= '<input type="checkbox" name="delete[]" value="' . $ID . '" id="' . $nome . $cognome . '"/>';
            $defForm .= '<label for="' . $nome . $cognome . '">' . $nome . ' ' . $cognome . '</label><br />';
        }

        $defForm .= '</fieldset><fieldset><legend>Rimuovi i volontari selezionati</legend><button type="submit" value="Delete" name="final_delete">Elimina</button></fieldset>';
        
    }

}

echo str_replace("<valoreForm />", $defForm, $paginaHTML);

?>