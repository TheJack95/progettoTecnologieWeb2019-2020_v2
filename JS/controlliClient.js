const form  = document.getElementsByTagName('form')[0];
const email = document.getElementById('mail');

const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

// Metodo Listener  per addEvent
function addEvent(element, event, callback) {
  let previousEventCallBack = element["on"+event];
  element["on"+event] = function (e) {
    const output = callback(e);
    if (output === false) return false;
    if (typeof previousEventCallBack === 'function') {
      output = previousEventCallBack(e);
      if(output === false) return false;
    }
  }
};

// Funzione di validazione
addEvent(window, "load", function () {
  const test = email.value.length === 0 || emailRegExp.test(email.value);
  email.className = test ? "valid" : "invalid";
});

// Mentre l'utente digita
addEvent(email, "input", function () {
  const test = email.value.length === 0 || emailRegExp.test(email.value);
  if (test) {
    email.className = "valid";
  } else {
    email.className = "invalid";
  }
});

// Quando l'utente submitta
addEvent(form, "submit", function () {
  const test = email.value.length === 0 || emailRegExp.test(email.value);
  if (!test) {
    email.className = "invalid";
    return false;
  } else {
    email.className = "valid";
  }
});
