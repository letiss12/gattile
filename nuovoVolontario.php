<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;
$paginaHTML = file_get_contents('volontario.html');
$messaggioPerForm = '';
$nome = ''; $cognome = ''; $dataNascita = ''; $citta = ''; $telefono = ''; $volontario = ''; $animali = ''; $ore = ''; $motivazione = '';
if (isset($_POST['submit'])) { 

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $dataNascita = $_POST['dataNascita'];
    $citta = $_POST['citta'];
    $telefono = $_POST['telefono'];
    $volontario = $_POST['volontariato'];
    $animali = $_POST['animali'];
    $ore = $_POST['oreVol'];
    $motivazione = $_POST['motivazione'];

    $dbAccess = new DBAccess();
    $openDBConnection = $dbAccess->openDBConnection();

    if ($openDBConnection == false) {
        die ("C'è stato un errore durante l'apertura del database");
    } else {

        if (strlen($nome) >= 2 && strlen($cognome) >= 2 && strlen($dataNascita) == 10 && strlen($citta) >= 2 && is_numeric($telefono) && strlen($telefono) >= 9 && is_numeric($ore) && strlen($ore) != 0 && strlen($motivazione) > 30) {        
            $risultatoInserimento = $dbAccess->inserisciVolontario($nome, $cognome, $dataNascita, $citta, $telefono, $volontario, $animali, $ore, $motivazione);
            $dbAccess->closeDBConnection();

            if($risultatoInserimento == false){
                $messaggioPerForm = '<div class="messForm"><p class="errore>Si è verificato un errore nell\'invio della tua richiesta. Riprova per favore.</p></div>';
            } else if ($risultatoInserimento == true)  {
                $messaggioPerForm = '<div class="messForm"><p class="completato>La tua richiesta è stata inviata correttamente, un sentito grazie da parte dello staff e di tutti i gatti!</p></div>';
                $nome = ''; $cognome = ''; $dataNascita = ''; $citta = ''; $telefono = ''; $volontario = ''; $animali = ''; $ore = ''; $motavazione = '';
            }

        } else {
            $dbAccess->closeDBConnection();
            $messaggioPerForm = '<div class="messForm><ul>';
            if (strlen($nome) < 2) {
                $messaggioPerForm .= '<li>Il nome inserito è troppo corto</li>';
            }
            if (strlen($cognome) < 2) {
                $messaggioPerForm .= '<li>Il cognome inserito è troppo corto</li>';
            }
            if (strlen($dataNascita) != 10) {
                $messaggioPerForm .= '<li>La data di nascita è stata inserita in modo errato, la forma corretta è GG/MM/AAAA</li>';
            }
            if (strlen($citta) < 2) {
                $messaggioPerForm .= '<li>Il nome della città inserita è troppo corto</li>';
            }
            if (strlen($telefono) < 9) {
                $messaggioPerForm .= '<li>Il numero di telefono inserito è troppo corto</li>';
            }
            if (!is_numeric($telefono)) {
                $messaggioPerForm .= '<li>Inserire il numero di telefono in formato numerico</li>';
            }
            if (strlen($ore) == 0) {
                $messaggioPerForm .= '<li>Inserire una quantità di ore maggiore di zero</li>';
            }
            if (!is_numeric($ore)) {
                $messaggioPerForm .= '<li>Inserire le ore in formato numerico</li>';
            }
            if (strlen($motivazione) < 30) {
                $messaggioPerForm .= '<li>La tua spiegazione deve essere di almeno 30 caratteri</li>';
            }
   
            $messaggioPerForm .= '</ul></div>';
        }

    }
}


$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreCognome />', $cognome, $paginaHTML);
$paginaHTML = str_replace('<valoreData />', $dataNascita, $paginaHTML);
$paginaHTML = str_replace('<valoreCitta />', $citta, $paginaHTML);
$paginaHTML = str_replace('<valoreTelefono />', $telefono, $paginaHTML);
$paginaHTML = str_replace('<valoreOre />', $ore, $paginaHTML);
$paginaHTML = str_replace('<valoreMotiv />', $motivazione, $paginaHTML);
echo $paginaHTML;

?>