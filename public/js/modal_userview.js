document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    const editForm = document.getElementById('editUserForm');
    let currentUserEmail = null;

    function openModal(modal) {
        modal.style.display = 'block';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }

    // Función para actualizar una fila en la tabla
    function actualizarFilaTabla(email, formData) {
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            const emailCell = row.getElementsByTagName('td')[1];
            if (emailCell && emailCell.textContent === email) {
                row.getElementsByTagName('td')[0].textContent = formData.get('nombre');
                emailCell.textContent = formData.get('correo');
                row.getElementsByTagName('td')[2].textContent = formData.get('rol');
                row.getElementsByTagName('td')[3].textContent = formData.get('area');
            }
        });
    }

    document.querySelectorAll('.close').forEach(element => {
        element.onclick = function() {
            closeModal(editModal);
            closeModal(deleteModal);
        };
    });

    window.onclick = function(event) {
        if (event.target === editModal || event.target === deleteModal) {
            closeModal(editModal);
            closeModal(deleteModal);
        }
    };

    // Capturar datos al abrir el modal de edición
    document.querySelectorAll('.edit').forEach(button => {
        button.onclick = function(e) {
            const row = e.target.closest('tr');
            const cells = row.getElementsByTagName('td');
            
            document.getElementById('editNombre').value = cells[0].textContent;
            document.getElementById('editCorreo').value = cells[1].textContent;
            document.getElementById('editRol').value = cells[2].textContent.toLowerCase();
            document.getElementById('editArea').value = cells[3].textContent.toLowerCase();
            
            // Guardamos el correo original para usarlo como identificador
            currentUserEmail = cells[1].textContent;
            
            openModal(editModal);
        };
    });

    // Capturar correo al abrir el modal de eliminación
    document.querySelectorAll('.delete').forEach(button => {
        button.onclick = function(e) {
            const row = e.target.closest('tr');
            currentUserEmail = row.getElementsByTagName('td')[1].textContent;
            openModal(deleteModal);
        };
    });

    // Manejar edición de usuario
    editForm.onsubmit = function(e) {
        e.preventDefault();
        const mensaje_edit = document.getElementById('mensaje_edit');
        const mensaje_delete = document.getElementById('mensaje_delete');
        const formData = new FormData();
        formData.append('action', 'edit');
        formData.append('correo_original', currentUserEmail);
        formData.append('nombre', document.getElementById('editNombre').value);
        formData.append('correo', document.getElementById('editCorreo').value);
        formData.append('rol', document.getElementById('editRol').value);
        formData.append('area', document.getElementById('editArea').value);

        fetch('../../app/models/editar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mensaje_edit.style.display = 'block';
                // Actualizar la fila en la tabla
                actualizarFilaTabla(currentUserEmail, formData);
                
                setTimeout(() => {
                    mensaje_edit.style.display = 'none';
                }, 6000);
            } else {
                alert('Error al actualizar usuario: ' + data.error);
            }
            closeModal(editModal);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar usuario');
            closeModal(editModal);
        });
    };

    // Manejar eliminación de usuario
    document.getElementById('confirmDelete').onclick = function() {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('correo', currentUserEmail);

        fetch('../../app/models/editar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const mensaje_delete = document.getElementById('mensaje_delete');
                mensaje_delete.style.display = 'block';
                // Eliminar la fila de la tabla
                const rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    const emailCell = row.getElementsByTagName('td')[1];
                    if (emailCell && emailCell.textContent === currentUserEmail) {
                        row.remove();
                    }
                });
                // Ocultar el mensaje después de 2 segundos
                setTimeout(() => {
                    mensaje_delete.style.display = 'none';
                }, 6000);
            } else {
                alert('Error al eliminar usuario: ' + data.error);
            }
            closeModal(deleteModal);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar usuario');
            closeModal(deleteModal);
        });
    };

    
});
