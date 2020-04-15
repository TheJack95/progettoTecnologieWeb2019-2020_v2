var dataInizioNolo = null;
var dataFineNolo = null;

const regexDate = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;

/**
 * Converte la data da gg-mm-aaaa a aaaa-mm-gg
 * @param {string} data la data nel formato gg-mm-aaaa
 * @param {string} type il tipo di ritorno (Date/string)
 * @param {string} separator il separatore nella data es. - o / 
 */
function dateReverse(data, type, separator) {
    let dataSplitted = data.split(separator);
    switch (type) {
        case "Date":
            return new Date(dataSplitted[2],dataSplitted[1]-1,dataSplitted[0]);
        case "string":
            return dataSplitted[2] + separator + dataSplitted[1] + separator + dataSplitted[0];
        default:
            console.error("Tipo " + type + " non ammesso");
            return "Invalid input 'type'";
    }
}

/**
 * Controlla se dataMag >= dataMin e se le date sono successive ad oggi
 * @param {string} dataMag data maggiore in string
 * @param {string} dataMin data minore in string
 */
function isDateValid(dataMag, dataMin) {
    let today = new Date();
    let dataMagDate = dateReverse(dataMag,"Date", "-");
    let dataMinDate = dateReverse(dataMin,"Date", "-");
    return dataMinDate >= today && dataMagDate >= dataMinDate;
}

var dataInizioChange = function(event) {
    if(event.target.value != "") {
        if(!regexDate.test(event.target.value)) {
            alert("Formato data inizio noleggio non valid0");
        } else {
            dataInizioNolo = event.target.value;
        }
        if(dataFineNolo != null) {
            let ggNolo = (dateReverse(dataFineNolo,"Date", "-") - dateReverse(dataInizioNolo,"Date", "-"))/86400000;
            calcolaCosto(ggNolo);
        }
    } else {
        document.getElementById('cosTot').innerHTML = "COSTO TOT: € 0";
    }
}

var dataFineChange = function(event) {
    if(event.target.value != "") {
        if(!regexDate.test(event.target.value)) {
            alert("Formato data fine noleggio non valido");
        } else {
            dataFineNolo = event.target.value;
            if(dataInizioNolo != null) {
                let ggNolo = parseInt((dateReverse(dataFineNolo,"Date", "-") - dateReverse(dataInizioNolo,"Date", "-"))/86400000);
                calcolaCosto(ggNolo);
            }
        }
    } else {
        document.getElementById('costoTot').innerHTML = "COSTO TOT: € 0";
    }
}

var checkDateNolo = function() {
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
    let costoGG = parseFloat(document.getElementById('costoNolo').innerText)
    let costoTot = ggNolo * costoGG;
    
    document.getElementById('costoTot').innerHTML = "COSTO TOT: € " + costoTot;
}