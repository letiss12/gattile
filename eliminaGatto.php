<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$pagina = file_get_contents('eliminaGatto.html');

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
                $risultato = $dbAccess->eliminaGatto($deleteID);
                $cont = $cont + 1;
            }

            $dbAccess->closeDBConnection();

            if($risultato == false) {
                $mess = '<div class="messForm"><p class="errore">Si è verificato un errore.</p><button><a href="formEliminaGatto.php">Torna indietro</a></button></div>';
            } else if ($risultato == true) {
                $gatt = '';
                if ($cont == 1) {
                    $gatt= 'gatto';
                } else if ($cont > 1) {
                    $gatt = 'gatti';
                }
                $mess = '<div class="messForm"><p class="completato">Hai rimosso con successo '. $cont . ' ' . $gatt . ' dal rifugio.</p><button><a href="vistaGatti.php">Torna alla Gestione Gatti</a></button></div>';
            }

        } else {
            $mess = '<div class="messForm"><p>Non hai selezionato alcun gatto, riprova.</p><button><a href="formEliminaGatto.php">Torna indietro</a></button></div>';
        }
    }   
}

$pagina = str_replace('<messaggiForm />', $mess, $pagina);

echo $pagina;

?>