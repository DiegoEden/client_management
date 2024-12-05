document.addEventListener('DOMContentLoaded', function () {
    let current_url = document.location;
    /*     console.log(current_url);
     */
    var path = window.location.pathname;
    var page = path.split("/").pop();
/*     console.log(page);
 */    document.querySelectorAll(".nav-link").forEach(function (e) {
        if (e.href == current_url) {
            e.classList += " current";
        }
        if (page == "clients.php") {
            document.getElementById('clients').classList.add('current');
        }
        if (page == "dasboard.php") {
            document.getElementById('dashboard').classList.add('current');
        }
       
    });

    load();
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
            modoOscuro();

        }
    });

    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', event => {
        if (event.matches) {
            modoClaro();
        }

    });


});



function load() {



    let mode = localStorage.getItem("mode");
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches || mode == 'claro' || mode == '' || mode == null) {
        modoClaro();
    }


    else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches || mode == 'oscuro') {
        modoOscuro();

    }

    let estado = localStorage.getItem('estado');
    if (estado == 'active' || estado == null) {
        document.documentElement.style.setProperty('--animation', 'none');

    }



}



function modoOscuro() {

    document.documentElement.style.setProperty('--body-color', '#161412');
    document.documentElement.style.setProperty('--color-fondoNav', '#353331');
    document.documentElement.style.setProperty('--color-fondo', '#191B34');
    document.documentElement.style.setProperty('--colorLetra', "#FFFFFF");
    document.documentElement.style.setProperty('--colorTexto', "#000000");
    document.documentElement.style.setProperty('--color-tarjeta', "#282828");


    //document.getElementById('logoNav').src = "../../resources/img/logoOscuro.png";


    localStorage.setItem('mode', 'oscuro');
    document.documentElement.style.setProperty('--colorSlider', '#FFFFFF');
    var navbar = document.getElementById("navbar");
    navbar.style.setProperty("transition", ".6s");

   var footer = document.querySelector("footer");
    footer.style.setProperty("transition", ".6s");


    document.getElementById("oscuro").style.setProperty("display", "none");
    document.getElementById("claro").style.setProperty("display", "block");
    document.getElementById("claro").style.setProperty("transition", ".6s");
    document.getElementById("oscuro").style.setProperty("transition", ".6s");
    document.documentElement.style.setProperty('--imgToggle', 'url("../img/menuOscuro.png")');
    document.documentElement.style.setProperty('--animation', '.6s');
    localStorage.setItem('estado', 'active');
   

    var path = window.location.pathname;
    var page = path.split("/").pop();
    /*     console.log(page);
     */
  /*  if (page == "proyecto.php") {
        document.getElementById('proyectos').className = "d-none";
        document.getElementById('proyectos2').className = "row justify-content-center animate__animated animate__backInUp";
    }


    if (page == "" || page == "index.php" || page == null) {
        document.getElementById('imgwsacademy').src = "../../resources/img/wsacademyOscuro.png";
        document.getElementById('bannerMobile').src = "../../resources/img/wsacademyOscuro.png";

    }
*/



}


function modoClaro() {

    document.documentElement.style.setProperty('--color-fondo', '#FFFFFF');
    document.documentElement.style.setProperty('--color-fondoNav', '#E4E4E4');

    document.documentElement.style.setProperty('--body-color', '#FFFFFF');
    document.documentElement.style.setProperty('--color-spinner', '#191B34');

    document.documentElement.style.setProperty('--colorTexto', "#FFFFFF");
    document.documentElement.style.setProperty('--color-tarjeta', "#E4E4E4");

    document.documentElement.style.setProperty('--colorLetra', "#000000");
    //document.getElementById('logoNav').src = "../../resources/img/logoClaro.png";



    localStorage.setItem('mode', 'claro');
    document.documentElement.style.setProperty('--colorSlider', '#F2F2F2');
    document.getElementById("claro").style.setProperty("display", "none");
    document.getElementById("oscuro").style.setProperty("display", "block");
    document.getElementById("claro").style.setProperty("transition", ".6s");
    document.getElementById("oscuro").style.setProperty("transition", ".6s");


    document.documentElement.style.setProperty('--imgToggle', 'url("../img/menu.png")');
    document.documentElement.style.setProperty('--animation', '.6s');
    localStorage.setItem('estado', 'active');

    var path = window.location.pathname;
    var page = path.split("/").pop();
    /*     console.log(page);
     */
   






}