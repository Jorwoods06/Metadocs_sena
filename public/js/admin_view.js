
const inputBusqueda = document.getElementById('inputBusqueda');
const areaFilter = document.getElementById('areaFilter');
const tabla = document.querySelector('table tbody');

// Función para filtrar los usuarios
function filtrarUsuarios() {
    const textoBusqueda = inputBusqueda.value.toLowerCase();
    const areaSeleccionada = areaFilter.value.toLowerCase();
    const filas = tabla.getElementsByTagName('tr');

    for (let fila of filas) {
        const celdas = fila.getElementsByTagName('td');
        if (celdas.length === 0) continue; 

        const nombre = celdas[0].textContent.toLowerCase();
        const area = celdas[3].textContent.toLowerCase();

       
        const coincideTexto = nombre.includes(textoBusqueda);
        const coincideArea = !areaSeleccionada || area === areaSeleccionada;

      
        fila.style.display = (coincideTexto && coincideArea) ? '' : 'none';
    }
}


inputBusqueda.addEventListener('input', filtrarUsuarios);
areaFilter.addEventListener('change', filtrarUsuarios);


function inicializarFiltroAreas() {
    const areas = new Set();
    const filas = tabla.getElementsByTagName('tr');
    
    for (let fila of filas) {
        const celdas = fila.getElementsByTagName('td');
        if (celdas.length > 0) {
            areas.add(celdas[3].textContent.trim());
        }
    }

    
    while (areaFilter.options.length > 1) {
        areaFilter.remove(1);
    }

    
    areas.forEach(area => {
        const option = new Option(area, area.toLowerCase());
        areaFilter.add(option);
    });
}


document.addEventListener('DOMContentLoaded', () => {
    inicializarFiltroAreas();
});