<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('nuovoGattoForm.html');

$messaggioPerForm = '';
$nome = ''; $genere = ''; $adozione = ''; $descrizione = '';

if (isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $adozione = $_POST['adozione'];
    $genere = $_POST['genere'];
    /*
    if ($adozione == 'si') {
        $adozione = 1;
    } else if ($adozione == 'no') {
        $adozione = 0;
    }*/
    $imm = ''; $altImm = '';


    if (strlen($nome) > 2 && strlen($descrizione) > 10) {
        $dbAccess = new DBAccess();
        $openDBConnection = $dbAccess->openDBConnection();
        $risultatoInserimento = $dbAccess->inserisciGatto($nome, $genere, $adozione, $descrizione, $imm);
        $dbAccess->closeDBConnection();

        if($risultatoInserimento == false){
            $messaggioPerForm = '<div id="errori"><p>Si è verificato un errore nella registrazione del gatto, riprova per favore.</p></div>';
        } else if ($risultatoInserimento == true)  {
            $messaggioPerForm = '<div id="inserito"><p>Un nuovo piccolo felino è stato registrato al rifugio!</p></div>';
            $nome = ''; $descrizione = '';
        }
    }
    else {
        $messaggioPerForm = '<div id="errori"><ul>';
        if (strlen($nome) <= 2) {
            $messaggioPerForm .= '<li>Il nome del gatto è troppo corto per essere inserito</li>';
        }
        if (strlen($descrizione) <= 10) {
            $messaggioPerForm .= '<li>Inserire una descrizione di almeno 10 caratteri per il gatto</li>';
        }
        $messaggioPerForm .= '</ul></div>';
    }

}

$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreDescr />', $descrizione, $paginaHTML);

echo $paginaHTML;

?>