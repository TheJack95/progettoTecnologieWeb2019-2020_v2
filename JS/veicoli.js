var dataInizioNolo = null;
var dataFineNolo = null;

var regexDate = /^(0?[1-9]|[12][0-9]|3[01])[-](0?[1-9]|1[012])[-]\d{4}$/;

/**
 * Converte la data da gg-mm-aaaa a aaaa-mm-gg
 * @param {string} data la data nel formato gg-mm-aaaa
 * @param {string} type il tipo di ritorno (Date/string)
 * @param {string} separator il separatore nella data es. - o / 
 */
function dateReverse(data, type, separator) {
    var dataSplitted = data.split(separator);
    var date = null;
    switch (type) {
        case "Date":
            date = new Date(dataSplitted[2],dataSplitted[1]-1,dataSplitted[0]);
            break;
        case "string":
            date =  dataSplitted[2] + separator + dataSplitted[1] + separator + dataSplitted[0];
            break;
        default:
            console.error("Tipo " + type + " non ammesso");
            date = "Invalid input 'type'";
            break;
    }

    return date;
}

/**
 * Controlla se dataMag >= dataMin e se le date sono successive ad oggi
 * @param {string} dataMag data maggiore in string
 * @param {string} dataMin data minore in string
 */
function isDateValid(dataMag, dataMin) {
    var today = new Date();
    var dataMagDate = dateReverse(dataMag,"Date", "-");
    var dataMinDate = dateReverse(dataMin,"Date", "-");
    return dataMinDate >= today && dataMagDate >= dataMinDate;
}

function dataInizioChange(event) {
    if(event.target.value != "") {
        if(!regexDate.test(event.target.value)) {
            alert("Formato data inizio noleggio non valid0");
        } else {
            dataInizioNolo = event.target.value;
        }
        if(dataFineNolo != null) {
            var ggNolo = (dateReverse(dataFineNolo,"Date", "-") - dateReverse(dataInizioNolo,"Date", "-"))/86400000;
            calcolaCosto(ggNolo);
        }
    } else {
        document.getElementById('cosTot').innerHTML = "COSTO TOT: € 0";
    }
}

function dataFineChange(event) {
    if(event.target.value != "") {
        if(!regexDate.test(event.target.value)) {
            alert("Formato data fine noleggio non valido");
        } else {
            dataFineNolo = event.target.value;
            if(dataInizioNolo != null) {
                var ggNolo = parseInt((dateReverse(dataFineNolo,"Date", "-") - dateReverse(dataInizioNolo,"Date", "-"))/86400000);
                calcolaCosto(ggNolo);
            }
        }
    } else {
        document.getElementById('costoTot').innerHTML = "COSTO TOT: € 0";
    }
}

function checkDateNolo() {
    if(dataInizioNolo && dataFineNolo) {
        if(isDateValid(dataFineNolo, dataInizioNolo))
            return true; 
        else {
            alert("Errore: le date devono essere successive ad oggi e la data di fine noleggio deve essere successiva alla data di inizio");
            return false;
        }
    }
    else {
        alert("Errore: date mancanti. Controlla di aver inserito correttamente le date di inizio e fine noleggio");
        return false;
    }
}

function calcolaCosto(ggNolo) {
    var costoGG = parseFloat(document.getElementById('costoNolo').innerText);
    var costoTot = parseInt(ggNolo * costoGG);
    
    document.getElementById('costoTot').innerHTML = "COSTO TOT: € " + costoTot;
}