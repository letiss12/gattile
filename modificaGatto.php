<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$pagina = file_get_contents('modificaGatto.html');

$mess = '<div class="messForm">';

if (isset($_POST['final_update'])) {
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();

    if ($connessioneRiuscita == false) {
        die ("C'è stato un errore durante l'apertura del database");
    } else {

    
        $cont = 0;
        if ( isset($_POST['updateAdot']) || isset($_POST['updateNonAdot']) )  {

            $risA = false; $contA = 0;
            foreach ($_POST['updateAdot'] as $updateID) {
                $risA = $dbAccess->modificaStatusAdottato($updateID);
                $contA = $contA + 1;
            }

            $risB = false; $contB = 0;
            foreach ($_POST['updateNonAdot'] as $updateID) {
                $risB = $dbAccess->modificaStatusNonAdottato($updateID);
                $contB = $contB + 1;
            }

            $dbAccess->closeDBConnection();

            if (!$risA && !$risB) {
                $mess .='<p class="errore>Si è verificato un errore.</p><button><a href="formModificaGatto.php">Torna indietro</a></button></div>';
            } else {
                if ($risA == true) {
                    $mess .= '<p>Hai aggiunto ai gatti adottati ' . $contA . ' gatto/i</p>';
                }
                if ($risB == true) {
                    $mess .= '<p>Hai aggiunto ai gatti non adottati ' . $contB . ' gatto/i</p>';
                }
                $mess .= '<button><a href="vistaGatti.php">Torna alla Gestione Gatti </a></button></div>';
            }

        } else {
            $mess = '<p>Non hai selezionato alcun gatto, riprova.</p><button><a href="formModificaGatto.php">Torna indietro</a></button></div>';
        }



    }
}

$pagina = str_replace('<messaggiForm />', $mess, $pagina);

echo $pagina;


?>