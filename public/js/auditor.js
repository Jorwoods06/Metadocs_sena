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
    const gestionUsuarios = document.getElementById("gestion_documento");
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

/*-------- menu documentos / expedientes --------- */

document.addEventListener('DOMContentLoaded', () => {
    
    const activadoresMenuAccion = document.querySelectorAll('.action-menu-trigger');

    
    const cerrarTodosLosMenus = () => {
        document.querySelectorAll('.action-dropdown-menu').forEach((menu) => {
            menu.style.display = 'none';
        });
    };

    
    activadoresMenuAccion.forEach((activador) => {
        activador.addEventListener('click', (evento) => {
            evento.stopPropagation(); // Prevenir la propagación del evento
            
            const menuDesplegable = activador.nextElementSibling; // Obtener el menú desplegable asociado
            const esMenuVisible = menuDesplegable.style.display === 'block';

          
            cerrarTodosLosMenus();

        
            if (!esMenuVisible) {
                menuDesplegable.style.display = 'block';
            }
        });
    });


    document.addEventListener('click', cerrarTodosLosMenus);

    // Evitar que el menú se cierre al hacer clic dentro de él
    document.querySelectorAll('.action-dropdown-menu').forEach((menu) => {
        menu.addEventListener('click', (evento) => {
            evento.stopPropagation();
        });
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

//-------------- modal para mostrar eliminacion de carpeta y documentos -----//
const deleteModal = document.getElementById('deleteModal');
const closeDeleteModal = deleteModal.querySelector('.close');
const confirmDeleteButton = document.getElementById('confirmDelete');
let currentExpedienteId = null;
let currentDocumentId = null;

document.addEventListener('DOMContentLoaded', () => {
    const deleteExpedienteButtons = document.querySelectorAll('.delete-expediente');
    const deleteDocumentButtons = document.querySelectorAll('.delete-document');
    const modalMessage = deleteModal.querySelector('p');
    const modalForm = deleteModal.querySelector('form');
    
    // Manejador para eliminar expedientes
    deleteExpedienteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const actionMenuTrigger = button.closest('tr').querySelector('.action-menu-trigger');
            currentExpedienteId = actionMenuTrigger.dataset.id;
            currentDocumentId = null;
            
            modalMessage.textContent = 'Esta acción eliminará el expediente y todos los documentos que contiene. ¿Estás seguro de que deseas continuar?';
            deleteModal.style.display = 'block';
            
            // Configurar el formulario para expedientes
            const hiddenInput = modalForm.querySelector('input[name="expediente_id"]');
            if (!hiddenInput) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'expediente_id';
                input.value = currentExpedienteId;
                modalForm.appendChild(input);
            } else {
                hiddenInput.value = currentExpedienteId;
            }
            confirmDeleteButton.value = 'borrar_expediente';
            
            const dropdowns = document.querySelectorAll('.action-dropdown-menu');
            dropdowns.forEach(dropdown => dropdown.style.display = 'none');
        });
    });

    // Manejador para eliminar documentos
    deleteDocumentButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const row = button.closest('tr');
            currentDocumentId = row.dataset.documentId; // Cambio aquí para usar data-document-id
            currentExpedienteId = null;
            
            modalMessage.textContent = 'Esta acción eliminará el documento de forma permanente. ¿Estás seguro de que deseas continuar?';
            deleteModal.style.display = 'block';
            
            // Configurar el formulario para documentos
            const hiddenInput = modalForm.querySelector('input[name="documento_id"]');
            if (!hiddenInput) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'documento_id';
                input.value = currentDocumentId;
                modalForm.appendChild(input);
            } else {
                hiddenInput.value = currentDocumentId;
            }
            confirmDeleteButton.value = 'borrar_documento';
            confirmDeleteButton.name = 'accion'; // Añadir el name al botón
            
            const dropdowns = document.querySelectorAll('.action-dropdown-menu');
            dropdowns.forEach(dropdown => dropdown.style.display = 'none');
        });
    });
});

// Cerrar modal con el botón X
closeDeleteModal.addEventListener('click', () => {
    deleteModal.style.display = 'none';
});

// Cerrar modal haciendo clic fuera
window.addEventListener('click', (e) => {
    if (e.target === deleteModal) {
        deleteModal.style.display = 'none';
    }
});





//-------codigo editar carpeta-------//




document.addEventListener('DOMContentLoaded', function() {
    // Obtener el modal
    const editModal = document.getElementById('editModal');
    
    // Obtener todos los botones de editar
    document.querySelectorAll('.edit-expediente').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const row = this.closest('tr');
            const expedienteId = row.getAttribute('data-url').split('=')[1];
            const nombre = row.querySelector('.item-name a').textContent.trim();
            
            // Rellenar el formulario con los datos actuales
            document.getElementById('edit_expediente_id').value = expedienteId;
            document.getElementById('nuevo_titulo').value = nombre;
            
            // Mostrar el modal
            editModal.style.display = 'block';
        });
    });
    
    // Cerrar el modal cuando se hace clic en la X
    editModal.querySelector('.close').addEventListener('click', function() {
        editModal.style.display = 'none';
    });
    
    // Cerrar el modal cuando se hace clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });
});