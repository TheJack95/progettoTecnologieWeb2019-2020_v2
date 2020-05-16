//espressioni regolari
var regex = [];
regex["email"] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
regex["mail"] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
regex["nome"] = /^[a-zA-Z ]{3,30}$/;
regex["cognome"] = /^[a-zA-Z ]{3,30}$/;
regex["messaggio"] = /^[a-zA-Z0-9€?$@&#()'!,+\-;:=_.\s]+$/;
regex["numeroTelefono"] = /^([\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6})*$/;
regex["password"] = /^[a-zA-Z0-9 ]+$/;
regex["indirizzo"] = /^([a-zA-Z ]{3,11})\s([a-zA-Z ]+\s)+(\d{1,3}([\/][a-zA-Z ])?)$/;
regex["nascita"] = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
regex["data"] = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
regex["oggetto"] = /^[a-zA-Z0-9€?$@&#()'!,+\-;:=_.\s]+$/;
regex["marca"] = /^[a-zA-Z0-9€?$@&#()'!,+\-;:=_.\s]+$/;
regex["modello"] = /^[a-zA-Z0-9€?$@&#()'!,+\-;:=_.\s]+$/;
regex["chilometri"] = /^[0-9]{1,9}$/;
regex["cilindrata"] = /^[0-9]{1,9}$/;
regex["prezzo"] = /^[0-9]{1,9}$/;
regex["descrizione"] = /^[a-zA-Z0-9€?$@&#()'!,+\-;:=_.\s]+$/;
regex["targa"] = /^[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}$/;
regex["costo"] = /^[0-9]{1,9}$/;
regex["cauzione"] = /^[0-9]{1,9}$/;
regex["telefono"] = /^([\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6})*$/;


var checkForm = function(idForm) {
    var text = "";
    var elements = document.forms[idForm].querySelectorAll("input,textarea");

    var inputsKO = "";

    for(var i = 0; elements && elements.length > i; ++i) {
      var nomeTag = elements[i].name;
      if (typeof regex[nomeTag] !== 'undefined'){
        if(elements[i].type != "submit" && elements[i].type != "file" && !validInput(elements[i], regex[nomeTag])) {
            inputsKO += elements[i].name + "\n";
            elements[i].className += " invalid";
        }
      }
    }

    if(idForm == "registrationForm")
        text += checkRegistrazione();

    if(inputsKO.length) {
        text += "I seguenti campi non sono validi:\n" + inputsKO;
        alert(text);
    }

    return text.length == 0;
};

function checkRegistrazione() {
    var text = "";

    if(document.getElementById("password").value != document.getElementById("ripetiPassword").value) {
        text += "Le password non coincidono.\n";
    }

    var diff_ms = Date.now() - new Date(document.getElementById("nascita").value);
    var age_dt = new Date(diff_ms);

    if(Math.abs(age_dt.getUTCFullYear() - 1970 < 18)) {
        text += "Devi essere maggiorenne per poterti iscrivere.\n";
    }
    return text;
}

function validInput(input, regex) {
    return input.value != "" && regex.test(input.value);
}