var dataInizioNolo = null;
var dataFineNolo = null;

const regexDate = /^([0-2][0-9]|(3)[0-1])(-)(((0)[0-9])|((1)[0-2]))(-)\d{4}$/;

var dataInizioChange = function(event) {
    if(!regexDate.test(event.target.value)) {
        alert("Formato data inizio noleggio non valid0");
    } else {
        dataInizioNolo = event.target.value;
    }

}

var dataFineChange = function(event) {
    if(!regexDate.test(event.target.value)) {
        alert("Formato data fine noleggio non valido");
    } else {
        dataFineNolo = event.target.value;

        //devo girare le date altrimenti su alcuni browser js ha problemi
        let dataFineNoloSplit = dataFineNolo.split("-");
        let datainizioNoloSplit = dataInizioNolo.split("-");

        let ggNolo = (new Date(dataFineNoloSplit[2],dataFineNoloSplit[1],dataFineNoloSplit[0]) - new Date(datainizioNoloSplit[2],datainizioNoloSplit[1],datainizioNoloSplit[0]))/86400000;
        let costoTot = ggNolo * parseFloat(document.getElementById('costoNolo').innerText);
        
        document.getElementById('cosTot').innerHTML = "COSTO TOT: € " + costoTot;
    }
}