var dettagli_form = {
	"nome": ["Nome",/([a-zA-Z])(\ )([a-zA-Z]){2,20}$/ ,"Inserisci il tuo nome"],
	"cognome": ["Cognome",/([a-zA-Z])(\ )([a-zA-Z]){2,20}$/ ,"Inserisci il tuo cognome"],
	"dataNascita": ["Data di Nascita",/\d{8,9}/ ,"Inserisci la tua data di nascita in formato GG/MM/AAAA" ],
	"citta": ["Città di residenza", ,"Inserisci il nome della città in cui risiedi"],
	"telefono": ["Numero di telefono", /\d{9,10}/ ,"Inserisci il tuo numero di telefono (cellulare o fisso)"],
	"oreVol": ["Ore da dedicare al volontariato", /\d{1,3}/ ,"Inserisci in formato numerico il numero di ore che puoi dedicare settimanalmente al volontariato"],
	"motivazione": ["Motivazione", /.{30,}/ ,"Spiega per quale motivo vorresti diventare volontario presso il Rifugio U.E.P.A. "]
};

function campoDefault(input) {
    
    input.className = "default-text"; // mi permette di definire il colore
    input.value = dettagli_form[input.id][0];

}

// devo farlo quando l'utente fa focus sulla casella di testo
function campoPerInput(input) {
    if (input.value == dettagli_form[input.id][0]) {
        input.value == "";
        input.className = "";
    }
}

// la invochiamo quando carichiamo la pag html
function caricamento() {

    for (var key in dettagli_form) {
        var input = document.getElementById(key);
        campoDefault(input);
        input.onfocus = function() {campoPerInput(this);};
    }
}

function mostraErrore(input) {

    var elemento = document.createElement("strong"); // nuovo elemento strong con la classe errore 
    elemento.className = "errori";
    elemento.appendChild(document.createTextNode(dettagli_form[input.id][2]));
    
    var p = input.parentNode; // lo span 
    p.appendChild(elemento); // 
}


function validazioneCampo(input) {

    var parent = input.parentNode; // recupero lo span dentro il quale c'è l'input
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }

    var regex = dettagli_form[input.id][1]; // dell elemento input che sto testando con key id elemento 1 che è espressione regolare
    var text = input.value;
    if (text.search(regex) != 0) { // search restituisce il punto da cui parte l'espressione regolare , se è 0 parte dall'inizio
    //se è -1 non c'è, se c'è 7 allora parte dalla posizione 7
    //o non ho trovato l'espressione regolare o l'espressione regolare parte più avanti
        mostraErrore(input);

        return false;
    } else {
        return true;
    }

}


function validateForm() {
    // itera gli elementi dentro dettagli form 

    var corretto = true;
    for (var key in dettagli_form) {
        var input = document.getElementById(key);
        var risultato = validazioneCampo(input);
        corretto = corretto && risultato;

    }
    return corretto;
}

