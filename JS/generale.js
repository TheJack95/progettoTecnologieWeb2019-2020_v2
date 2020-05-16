function toggleMenu(item) {
    item.classList.toggle("change");
    var menu = document.getElementById('menu');
    menu.classList.toggle("menuMobile");
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollUp").classList.remove("hide");
    }
    else{
        document.getElementById("scrollUp").classList.add("hide");
    }
}

function topFunctionMouse() {
    
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
}

function topFunctionKey(e) {
    if(event.which == 13 || event.keyCode == 13){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    else
        return false;
}