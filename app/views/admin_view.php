<?php
require_once '../../app/models/logout_bdd.php';



require_once '../helpers/verificar_rol.php';
checkAuthorization('administrador');


require_once '../models/lista.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/admin.css">
    <link rel="stylesheet" href="../../public/css/admin_view.css">
    
</head>
<body>
    <header id="cabeza" name="cabeza">
        <figure id="logo" name="logo">
            <img src="../../public/imagenes/image.png" alt="logo">
        </figure>
        <div class="menu-toggle" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <nav id="iconos" name="iconos">
            <ul>
                
                <li>
                    <button type="submit" id="btn_sesion"><i class="fa-solid fa-circle-user"></i></button>
                </li>
            </ul>
        </nav>
    </header>

    <main id="cuerpo" name="cuerpo">
    <nav id="menu-lateral" class="menu-lateral">
            <ul>
                <li>
                    <a href="../../app/views/admin.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="M7 14v4"/>
                            <path d="M11 10v8"/>
                            <path d="M15 6v12"/>
                        </svg>
                        Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                        </svg>
                        Gestión Usuarios
                    </a>
                    <ul class="sub_menu">
                        <li><a href="../../app/views/admin_user.php">Crear usuario</a></li>
                        <li><a href="#" class="active">Ver usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../../app/views/admin_report.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                            <path d="M9 8h6"/>
                            <path d="M9 12h4"/>
                            <path d="M9 16h6"/>
                        </svg>
                        Reportes
                    </a>
                </li>
                <li class="solo_mobil" >
                    <a href="#" id ="solo_mobil" >
                        
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 19L8 12L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="8" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                                Volver
                    </a>
                </li>
            </ul>
        </nav>

        <article id="panel_admin" class="panel_admin">
            <div class="user-list-container">
                <h1>Lista de Usuarios</h1>
                <div class="filters">
                    <input type="text" placeholder="Buscar usuarios..." id="inputBusqueda">
                    <select id="areaFilter">
                        
                        <option value="">Todas las áreas</option>
                        <option value="desarrollador">Contabilidad</option>
                        <option value="diseñador">administracion</option>
                        <option value="gerente">Logistica</option>
                        <option value="gerente">Otro</option>
                       
                    </select>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($fila['nombres']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['correo']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['rol']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['area']) . "</td>";
                                echo "<td class='acciones'>
                                    <button class='edit'><i class='fa-solid fa-pen'></i></button>
                                    <button class='delete'><i class='fa-solid fa-trash'></i></button>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No hay usuarios en el sistema.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </article>

        <?php include 'logout.php'; ?>
    </main>


    <!-- Modal para editar usuario -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Usuario</h2>
        <form id="editUserForm">
            <input type="hidden" id="editUserId">
            <div class="form-group">
                <label for="editNombre">Nombre:</label>
                <input type="text" id="editNombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="editCorreo">Correo:</label>
                <input type="email" id="editCorreo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="editRol">Rol:</label>
                <select id="editRol" name="rol" required>
                    <option value="administrador">Administrador</option>
                    <option value="documentador">Documentador</option>
                    <option value="auditor">Auditor</option>
                    <option value="visualizador">visualizador</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editArea">Área:</label>
                <select id="editArea" name="area" required>
                    <option value="contabilidad">Contabilidad</option>
                    <option value="administracion">Administración</option>
                    <option value="logistica">Logística</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirmar eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
        <div class="form-actions">
            <button id="confirmDelete" class="btn-delete">Eliminar</button>
        </div>
    </div>
</div>


<div id="mensaje_edit" class="edit" style="display:none">
    <div id="contenido">
        <p>Usuario actualizado correctamente</p>
    </div>
</div>

<div id="mensaje_delete" class="edit" style="display:none">
    <div id="contenido">
        <p>Usuario eliminado correctamente</p>
    </div>
</div>




    <script src="../../public/js/menuadmin.js"></script>
    <script src="../../public/js/admin_view.js"></script>
    <script src="../../public/js/modal_userview.js"></script>
</body>
</html>
