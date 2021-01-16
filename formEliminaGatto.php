<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('eliminaGatto.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
    // si chiude senza dare una risposta all'utente fare un try catch
} else {
    $listaGatti = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    $defForm = '';
    if ($listaGatti != null) {

        $defForm = '<fieldset>';

        foreach ($listaGatti as $gatto) {
            $ID = $gatto['ID'];
            $nome = $gatto['Nome'];
            $defForm .= '<input type="checkbox" name="delete[]" value="' . $ID . '" id="' . $nome . '"/>';
            $defForm .= '<label for="' . $nome . '">' . $nome . '</label>';
        }

        $defForm .= '</fieldset>';
    }

}

echo str_replace("<valoreForm />", $defForm, $paginaHTML);

?>