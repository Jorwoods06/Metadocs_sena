document.addEventListener('DOMContentLoaded', () => {
    const btnCrearCarpeta = document.getElementById('btn_carpet');
    const formCarpeta = document.getElementById('cont_carpeta');
    const closeModal = document.querySelector('#titulo_carpeta_header .close');

    // Mostrar el formulario al hacer clic en el botón "Crear carpeta"
    btnCrearCarpeta.addEventListener('click', (e) => {
        e.preventDefault();
        formCarpeta.style.display = 'block';
    });

    // Ocultar el formulario al hacer clic en la "X" (cerrar)
    closeModal.addEventListener('click', () => {
        formCarpeta.style.display = 'none';
    });

    // Ocultar el formulario si se hace clic fuera del formulario
    window.addEventListener('click', (e) => {
        if (e.target === formCarpeta) {
            formCarpeta.style.display = 'none';
        }
    });

    const btnCrearDocumento = document.getElementById('btn_documento');
    const formDocumento = document.getElementById('cont_documento');
    const closeModal2 = document.querySelector('#cont_documento .close');
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-input');
    const cancelUploadBtn = document.getElementById('cancel-upload');
    const uploadForm = document.getElementById('upload-form');
    
    // Evento para abrir el modal
    btnCrearDocumento.addEventListener('click', (e) => {
        e.preventDefault();
        formDocumento.style.display = 'block';
    });
    
    // Evento para cerrar el modal con la X
    closeModal2.addEventListener('click', () => {
        formDocumento.style.display = 'none';
        resetUploadArea();
    });
    
    // Evento para cerrar el modal haciendo clic fuera
    window.addEventListener('click', (e) => {
        if (e.target === formDocumento) {
            formDocumento.style.display = 'none';
            resetUploadArea();
        }
    });
    
    // Evento para el botón cancelar 
    cancelUploadBtn.addEventListener('click', (e) => {
        e.preventDefault();
        resetUploadArea();
    });
    
    // Evento para simular clic en input file
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });
    
    // Prevenir comportamientos por defecto para drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    // Agregar clase para efectos visuales durante el drag
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('drag-over');
        });
    });
    
    // Remover clase para efectos visuales al finalizar el drag
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('drag-over');
        });
    });
    
    // Eventos para manejar archivos
    uploadArea.addEventListener('drop', handleDrop, false);
    fileInput.addEventListener('change', handleFiles, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFileSelection(files);
    }
    
    function handleFiles(e) {
        const files = e.target.files;
        handleFileSelection(files);
    }
    
    function handleFileSelection(files) {
        // Crear un objeto DataTransfer
        const dataTransfer = new DataTransfer();
        
        // Agregar los archivos al DataTransfer
        Array.from(files).forEach(file => {
            dataTransfer.items.add(file);
        });
        
        // Asignar los archivos al input file
        fileInput.files = dataTransfer.files;
        
        // Limpiar detalles de archivo previos
        const existingDetails = uploadArea.querySelector('.file-details');
        if (existingDetails) {
            existingDetails.remove();
        }
    
        // Crear div para mostrar detalles del archivo
        const fileDetailsDiv = document.createElement('div');
        fileDetailsDiv.className = 'file-details';
    
        Array.from(files).forEach(file => {
            const fileName = file.name;
            const fileSize = formatFileSize(file.size);
    
            const fileDetails = document.createElement('p');
            fileDetails.textContent = `${fileName} (${fileSize})`;
            fileDetailsDiv.appendChild(fileDetails);
        });
    
        // Ocultar el label original y mostrar los detalles
        const uploadLabel = uploadArea.querySelector('.upload-label');
        if (uploadLabel) {
            uploadLabel.style.display = 'none';
        }
        uploadArea.appendChild(fileDetailsDiv);
    
        // Mostrar botones de acción
        const actionButtonsContainer = document.getElementById('action-buttons-container');
        actionButtonsContainer.style.display = 'block';
    }
    
    function resetUploadArea() {
        // Limpiar el input file
        fileInput.value = '';
        
        // Remover detalles del archivo si existen
        const fileDetails = uploadArea.querySelector('.file-details');
        if (fileDetails) {
            fileDetails.remove();
        }
    
        // Mostrar el label original
        const uploadLabel = uploadArea.querySelector('.upload-label');
        if (uploadLabel) {
            uploadLabel.style.display = 'block';
        }
    
        // Ocultar botones de acción
        const actionButtonsContainer = document.getElementById('action-buttons-container');
        actionButtonsContainer.style.display = 'none';
    
        // Remover la clase drag-over si existe
        uploadArea.classList.remove('drag-over');
    }
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        else if (bytes < 1048576) return (bytes / 1024).toFixed(0) + ' KB';
        else return (bytes / 1048576).toFixed(1) + ' MB';
    }})



    document.querySelectorAll("tbody tr").forEach((row) => {
        row.addEventListener("click", (event) => {
          // Ignorar clics en el botón del menú
          if (!event.target.closest(".ver-detalles")) {
            const url = row.getAttribute("data-url");
            if (url) {
              window.location.href = url;
            }
          }
        });
      });
      