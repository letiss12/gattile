<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$pagina = file_get_contents('eliminaGatto.html');

$messaggioPerForm = '';

if (isset($_POST['final_delete'])) {
    $dbAccess = new DBAccess();
    $openDBConnection = $dbAccess->openDBConnection();
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteID) {
            $risultato = $dbAccess->eliminaGatto($deleteID);
        }
    }
    $dbAccess->closeDBConnection();

    if($risultato == false) {
        $messaggioPerForm = '<div id="errori"><p>Si è verificato un errore.</p></div>';
    } else if ($risultato == true) {
        $messaggioPerForm = '<div id="inserito"><p>Eliminazione completata</p></div>';
    }
    
}

$pagina = str_replace('<messaggiForm />', $messaggioPerForm, $pagina);

echo $pagina;

?>