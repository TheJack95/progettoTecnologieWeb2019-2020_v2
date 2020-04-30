function toggleMenu(item) {
    item.classList.toggle("change");
    let menu = document.getElementById('menu');
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

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0; 
  }