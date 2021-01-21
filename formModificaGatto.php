<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('modificaGatto.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
    die ("C'è stato un errore durante l'apertura del database");
} else {
    $listaGatti = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();
    $defForm = '';
    if ($listaGatti != null) {
        $defForm = '<fieldset><legend>Qualcuno di questi gatti è stato adottato di recente?</legend>';
        foreach ($listaGatti as $gatto) {
            if ($gatto['Adozione'] == 0) {
                $ID = $gatto['ID'];
                $nome = $gatto['Nome'];
                $nomeF = $gatto.$ID;
                $nomeF = trim($nomeF);
                $defForm .= '<input type="checkbox" name="updateAdot[]" value="' . $ID . '" id="' . $nomeF . '"/>';
                $defForm .= '<label for="' . $nomeF . '">' . $nome . '</label><br />';
            }
        }
        $defForm .= '</fieldset><fieldset><legend>Qualcuno di questi gatti è stato riportato in rifugio?</legend>'; 
        foreach ($listaGatti as $gatto) {
            if ($gatto['Adozione'] == 1) {
                $ID = $gatto['ID'];
                $nome = $gatto['Nome'];
                $nomeF = $gatto.$ID;
                $nomeF = trim($nomeF);
                $defForm .= '<input type="checkbox" name="updateNonAdot[]" value="' . $ID . '" id="' . $nomeF . '"/>';
                $defForm .= '<label for="' . $nomeF . '">' . $nome . '</label><br />';
            }
        }
        $defForm .= '</fieldset><fieldset><legend>Modifica lo status del gatti selezionati</legend><button type="submit" value="Update" name="final_update">Modifica</button></fieldset>';   

        
    }    
}
echo str_replace("<valoreForm />", $defForm, $paginaHTML);
?>
