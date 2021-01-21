<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$pagina = file_get_contents('eliminaVolontario.html');

$mess = '';

if (isset($_POST['final_delete'])) {
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();

    if ($connessioneRiuscita == false) {
        die ("C'è stato un errore durante l'apertura del database");
    } else {
        $risultato = false;
        $cont = 0;
        if (isset($_POST['delete'])) {

            foreach ($_POST['delete'] as $deleteID) {
                $risultato = $dbAccess->eliminaVolontario($deleteID);
                $cont = $cont + 1;
            }
        
            $dbAccess->closeDBConnection();

            if($risultato == false) {
                $mess = '<div class="messForm" id="errore"><p>Si è verificato un errore.</p><button><a href="formEliminaVolontario.php">Torna indietro</a></button></div>';
            } else if ($risultato == true) {
                $vol = '';
                if ($cont == 1) {
                    $vol = 'volontario';
                } else if ($cont > 1) {
                    $vol = 'volontari';
                }
                $mess = '<div class="messForm id="completato"><p>Hai rimosso con successo ' . $cont . ' ' . $vol . ' dalla lista.</p><button><a href="vistaVolontari.php">Torna alla Gestione Volontari</a></button></div>';
            }
        } else {
            $mess = '<div class="messForm"><p>Non hai selezionato alcuna persona, riprova.</p><button><a href="formEliminaVolontario.php">Torna indietro</a></button></div>';
        }
    }      
}

$pagina = str_replace('<messaggiForm />', $mess, $pagina);

echo $pagina;

?>