<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$pagina = file_get_contents('eliminaVolontario.html');

$mess = '';

if (isset($_POST['final_delete'])) {
    $dbAccess = new DBAccess();
    $openDBConnection = $dbAccess->openDBConnection();
    $risultato = false;
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteID) {
            $risultato = $dbAccess->eliminaVolontario($deleteID);
        }
    }
    $dbAccess->closeDBConnection();

    if($risultato == false) {
        $mess = '<div id="errori"><p>Si è verificato un errore.</p></div>';
    } else if ($risultato == true) {
        $mess = '<div id="inserito"><p>Eliminazione completata</p></div>';
    }
    
}

$pagina = str_replace('<messaggiForm />', $mess, $pagina);

echo $pagina;

?>