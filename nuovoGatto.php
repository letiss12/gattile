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
    $imm = ''; 
    
  // if ($connessioneRiuscita == false) {
    //    $messaggioPerForm ='C\'è stato un errore durante l\'apertura del database';
  //  } else {

        if (strlen($nome) > 2 && strlen($descrizione) > 10) {
            $dbAccess = new DBAccess();
            $connessioneRiuscita = $dbAccess->openDBConnection();
            $risultatoInserimento = $dbAccess->inserisciGatto($nome, $genere, $adozione, $descrizione, $imm);
            $dbAccess->closeDBConnection();

            if($risultatoInserimento == false){
                $messaggioPerForm = '<div class="messForm id="errore"><p>Si è verificato un errore nella registrazione del gatto, riprova per favore.</p></div>';
            } else if ($risultatoInserimento == true)  {
                $messaggioPerForm = '<div class="messForm id="completato"><p>Un nuovo piccolo felino è stato registrato al rifugio!</p></div>';
                $nome = ''; $descrizione = '';
            }

        } else {
            //$dbAccess->closeDBConnection();
            $messaggioPerForm = '<div class="messForm id="errore"><ul>';
            if (strlen($nome) <= 2) {
                $messaggioPerForm .= '<li>Il nome del gatto è troppo corto per essere inserito</li>';
            }
            if (strlen($descrizione) <= 10) {
                $messaggioPerForm .= '<li>Inserire una descrizione di almeno 10 caratteri per il gatto</li>';
            }
            $messaggioPerForm .= '</ul></div>';
        }

    //}

}

$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreDescr />', $descrizione, $paginaHTML);

echo $paginaHTML;

?>