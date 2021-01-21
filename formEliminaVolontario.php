<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('eliminaVolontario.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $listaVol = $dbAccess->getListaVolontari();
    $dbAccess->closeDBConnection();

    $defForm = '';
    if ($listaVol != null) {

        $defForm = '<fieldset><legend>Persone a disposizione del rifugio</legend>';

        foreach ($listaVol as $vol) {
            $ID = $vol['ID'];
            $nome = $vol['Nome'];
            $cognome = $vol['Cognome'];
            $nomcom = $nome.$cognome;
            $nomcom = trim($nomcom);
            $defForm .= '<input type="checkbox" name="delete[]" value="' . $ID . '" id="' . $nomcom . '"/>';
            $defForm .= '<label for="' . $nomcom . '">' . $nome . ' ' . $cognome . '</label><br />';
        }

        $defForm .= '</fieldset><fieldset><legend>Rimuovi i volontari selezionati</legend><button type="submit" value="Delete" name="final_delete">Elimina</button></fieldset>';
        
    }

}

echo str_replace("<valoreForm />", $defForm, $paginaHTML);

?>