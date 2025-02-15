let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp() {
    tabs(); // Cambiar seccion cuando se presionen los tabs. 
    mostrarSeccion(); // 
    botonesPaginador(); 
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); // Extraer servicios de endpoint. 

    nombreCliente(); // Anade el nombre del cliente en memoria
    seleccionarFecha();
}

function mostrarSeccion() {

    // Ocultar la seccion de clase que tenga mostar: 
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la seccion con el paso:
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.toggle('mostrar');

    // Cambia estado del tab previo: 
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }
    
    // Resalta el tab actual:
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.toggle('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    }); 
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector("#anterior");
    paginaAnterior.addEventListener('click', function(e) {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector("#siguiente");
    paginaSiguiente.addEventListener('click', function(e) {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector("#anterior");
    const paginaSiguiente = document.querySelector("#siguiente");
    
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

async function consultarAPI() {

    try {
        const url = "http://localhost:3000/api/servicios";
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach (servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${precio}`;

        const servicioDiv =  document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector("#servicios").appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio) {
    const {id} = servicio 
    const {servicios } = cita;

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado: 
    if (servicios.some(agregado => agregado.id === id)) {
        divServicio.classList.remove('seleccionado');
        cita.servicios = servicios.filter(agregado => agregado.id != id);
    } else {
        divServicio.classList.add('seleccionado');
        cita.servicios = [...servicios, servicio];
    }

    
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre');
    cita.nombre = nombre.value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('change', function(e) {
        const dia = new Date(e.target.value).getUTCDay();
        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Fines de Semana no permitidos', 'error');
        }
    })
}

function mostrarAlerta(mensaje, tipo) {
    // Prevenir que se cree mas de una alerta: 
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) return;

    // Scripting para crear alerta:
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const formulario = document.querySelector('.formulario');
    formulario.appendChild(alerta);

    // Eliminar la alerta:
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}
