
//-------codigo menu hamburgesa-------//

const menuToggle = document.getElementById('menu-toggle');
const menuLateral = document.getElementById('menu-lateral');

let startX = 0; 


menuToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    menuLateral.classList.toggle('open');
});


document.addEventListener('click', (e) => {
    if (!menuLateral.contains(e.target) && !menuToggle.contains(e.target)) {
        menuLateral.classList.remove('open');
    }
});


menuLateral.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX; 
});

menuLateral.addEventListener('touchend', (e) => {
    const endX = e.changedTouches[0].clientX; 
    const deltaX = endX - startX; 

    if (deltaX < -50) { 
        menuLateral.classList.remove('open'); 
    }
});




document.addEventListener("DOMContentLoaded", function () {
    const gestionUsuarios = document.getElementById("gestion-usuarios");
    const liPadre = gestionUsuarios.parentElement; 

    gestionUsuarios.addEventListener("click", function (e) {
        e.preventDefault();
        liPadre.classList.toggle("open"); 
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const devolver = document.getElementById('solo_mobil')

    devolver.addEventListener("click", ()=>{ 
        menuLateral.classList.remove('open'); 
    });
});





//-------codigo cerrar sesion-------//


const cerrar_sesion = document.getElementById('cerrar_sesion');
const btn_sesion = document.getElementById('btn_sesion');

btn_sesion.addEventListener('click', (e)=> {
    e.stopPropagation(); // Evita que el click se propague al documento
    if (cerrar_sesion.style.display === 'block') {
        cerrar_sesion.style.display = 'none';
    } else {
        cerrar_sesion.style.display = 'block';
    }
});

// Cerrar al hacer clic fuera del menú
document.addEventListener('click', (e)=> {
    if (!cerrar_sesion.contains(e.target) && !btn_sesion.contains(e.target)) {
        cerrar_sesion.style.display = 'none';
    }
});


