let paso = 1;

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp() {
    tabs(); // Cambiar seccion cuando se presionen los tabs. 
    mostrarSeccion(); // 

}

function mostrarSeccion() {
    // Seleccionar la seccion con el paso:
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
        });
    }); 
}

