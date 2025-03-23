<?php
require_once '../helpers/verificar_rol.php';
checkAuthorization('auditor');

require_once '../models/create_carpeta.php';



$padre_id = isset($_GET['id_expediente']) ? $_GET['id_expediente'] : 0;
$expediente_seleccionado = $padre_id;
$carpetas = obtenerCarpetas($conexion_metadocs, $padre_id, $area);
$documentos = obtenerDocumentos($conexion_metadocs, $padre_id, $area);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
    <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/auditor.css">
    <link rel="stylesheet" href="../../public/css/auditor_doc.css">
</head>
<body>
    <!-- Header -->
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
    
    <!-- Cuerpo -->
    <main id="cuerpo" name="cuerpo">
    <nav id="menu-lateral" class="menu-lateral">
            <ul>
                <li>
                    <a href="./../views/auditor.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg> Inicio
                    </a>
                </li>
                <li class="gestion_documento">
                    <a href="#" id="gestion_documento">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg> Gestión documentos
                    </a>
                    <ul class="sub_menu">
                        <li><a href="#">Solicitudes</a></li>
                        <li><a href="./../views/auditor_doc.php" id="gestion-documentos" class="active">Ver documentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg> Pista auditoria
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg> Retención
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg> Tareas
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
    <div id="cont_carpetas">
        <!-- Título y botones cuando hay expediente seleccionado -->
        <?php if ($expediente_seleccionado): ?>
        <div class="title-button-container">
            <h1>Documentos</h1>
            <div class="header-buttons">
                <button type="submit" id="btn_documento">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg> Subir documento
                </button>
                <button type="submit" id="btn_carpet">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg> Crear carpeta
                </button>
            </div>
        </div>
        <?php else: ?>
        <!-- Título sin botones cuando NO hay expediente seleccionado -->
        <div class="title-container">
            <h1>Documentos</h1>
        </div>
        <?php endif; ?>

        <?php if ($expediente_seleccionado): ?>
        <div class="breadcrumb">
            <a href="?">Inicio</a> / 
            <a href="javascript:history.back()" class="back-button">Atras</a> /
            <?php 
            $carpeta_actual = obtenerInfoCarpeta($conexion_metadocs, $expediente_seleccionado);
            if ($carpeta_actual) {
                echo htmlspecialchars($carpeta_actual['nombre']);
            } else {
                echo "Carpeta no encontrada";
            }
            ?>
        </div>
        <?php endif; ?>
        
        <!-- Barra de búsqueda con botón cuando NO hay expediente seleccionado -->
        <div id="filtro" class="<?php echo !$expediente_seleccionado ? 'with-button' : ''; ?>">
            <input type="text" id="buscar_input" placeholder="Buscar carpeta o archivo...">
            <?php if (!$expediente_seleccionado): ?>
            <button type="submit" id="btn_carpet">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg> Crear carpeta
            </button>
            <?php endif; ?>
        </div>

        <div id="tabla_carpetas">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha subida</th>
                        <th>ㅤ</th>
                    </tr>
                </thead>
                <tbody id="t_cuerpo">
                    <?php 
                    // Variable para controlar si hay contenido
                    $tiene_contenido = false;
                    
                    // Mostrar carpetas
                    if (!empty($carpetas)):
                        $tiene_contenido = true;
                        foreach ($carpetas as $carpeta): 
                    ?>
                        <tr data-url="?id_expediente=<?= $carpeta['id_expediente']; ?>">
                            <td class="item-name">
                                <a href="?id_expediente=<?= $carpeta['id_expediente']; ?>">
                                    <i class="fa-regular fa-folder item-icon"></i> 
                                    <?= htmlspecialchars($carpeta['nombre']); ?>
                                </a>
                            </td>
                            <td>expediente</td>
                            <td><?= htmlspecialchars($carpeta['fecha_creacion']); ?></td>
                            <td class="actions-cell">
                                <button class="action-menu-trigger" data-id="<?= $carpeta['id_expediente']; ?>">
                                    <i class="fa-solid fa-ellipsis-vertical action-menu-icon"></i>
                                </button>
                                <div class="action-dropdown-menu">
                                    <button class="action-dropdown-item edit-expediente">
                                        <i class="fas fa-edit action-dropdown-icon"></i>
                                        Editar
                                    </button>
                                    <button class="action-dropdown-item delete-expediente">
                                        <i class="fas fa-trash-alt action-dropdown-icon"></i>
                                        Eliminar
                                    </button>
                                    <button class="action-dropdown-item" onclick="window.location.href='../models/create_carpeta.php?accion=descargar&documento_id=<?= $documento['id_documento'] ?>'">
                                        <i class="fas fa-download action-dropdown-icon"></i>
                                        Descargar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    endif;
                    
                    // Mostrar documentos si hay expediente seleccionado
                    if ($expediente_seleccionado && !empty($documentos)): 
                        $tiene_contenido = true;
                        foreach ($documentos as $documento): 
                    ?>
                        <tr data-document-id="<?= $documento['id_documento'] ?>">
                            <td class="item-name">
                                <i class="fa-regular fa-file item-icon"></i> 
                                <?= htmlspecialchars($documento['titulo']); ?>
                            </td>
                            <td><?= htmlspecialchars($documento['tipo']); ?></td>
                            <td><?= htmlspecialchars($documento['fecha_creacion']); ?></td>
                            <td class="actions-cell">
                                <button class="action-menu-trigger" data-id="doc-<?= $documento['id_documento'] ?>">
                                    <i class="fa-solid fa-ellipsis-vertical action-menu-icon"></i>
                                </button>
                                <div class="action-dropdown-menu">
                                    <button class="action-dropdown-item view-document">
                                        <i class="fa-regular fa-eye action-dropdown-icon"></i>
                                        Ver
                                    </button>
                                    <button class="action-dropdown-item delete-document">
                                        <i class="fas fa-trash-alt action-dropdown-icon"></i>
                                        Eliminar
                                    </button>
                                    <form method="post" action="../models/create_carpeta.php" style="display:inline;">
                                        <input type="hidden" name="accion" value="descargar_documento">
                                        <input type="hidden" name="documento_id" value="<?= $documento['id_documento'] ?>">
                                        <button type="submit" class="action-dropdown-item">
                                            <i class="fas fa-download action-dropdown-icon"></i>
                                            Descargar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endforeach;
                    endif;
                    
                    // Mostrar mensaje si no hay contenido
                    if (!$tiene_contenido): 
                    ?>
                        <tr>
                            <td colspan="4">No hay carpetas ni documentos para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div> 
</article>

        <!-- Modal para crear carpeta -->
        <div id="cont_carpeta" class="modal">
            <div id="form_carpeta">
                <form action="../models/create_carpeta.php" method="post">
                    <div id="titulo_carpeta_header">
                        <span class="close">&times;</span>
                        <h2>Crear carpeta</h2>
                    </div>
                    <div id="input_carpeta">
                        <label for="titulo_carpeta_input">Ingrese el título</label>
                        <input type="hidden" name="expediente_padre" value="<?= $expediente_seleccionado ?>">
                        <input type="text" id="titulo_carpeta_input" name="titulo_carpeta" placeholder="Ingrese el título de la carpeta" required>
                        
                        <label for="desc_carpeta_input">Descripción</label>
                        <textarea id="desc_carpeta_input" name="desc_carpeta" placeholder="Ingrese la descripción de la carpeta" required></textarea>
                    </div>
                    <div id="btn_carpeta">
                        <button type="submit" name="accion" value="crear_carpeta">Crear</button>
                    </div>  
                </form>
            </div>
        </div>

        <!-- Modal para subir documento -->
        <div id="cont_documento" class="modal">
            <form action="../models/create_carpeta.php" method="post" enctype="multipart/form-data" id="upload-form">
                <div class="file-uploader">
                    <span class="close">&times;</span>
                    <h2>Subir archivo</h2>
                
                    <div id="upload-area" class="upload-area">
                        <input type="file" id="file-input" name="file-input">
                        <label for="file-input" class="upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Arrastre y suelte archivos o haga clic para cargar</p>
                        </label>
                    </div>
                    
                    <!-- Campo oculto para el ID del expediente -->
                    <input type="hidden" name="expediente_id" value="<?= $expediente_seleccionado ?>">
                    
                    
                    <div class="form-group">
                        <label class="form-label" for="documentCategory">Categoría del documento:</label>
                        <select class="form-select" id="documentCategory" name="categoria" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="estrategicos">Estratégicos</option>
                            <option value="operativos">Operativos</option>
                            <option value="soporte">Soporte</option>
                            <option value="legales_contractuales">Legales</option>
                            <option value="financieros_contables">Financieros</option>
                            <option value="correspondencia">Correspondencia</option>
                        </select>
                    </div>
                    <div id="action-buttons-container" style="display: none; margin-top: 1rem;">
                        <button id="cancel-upload" type="button" style="margin-right: 1rem;">Cancelar</button>
                        <button id="upload-file" type="submit" name="accion" value="subir_documento">Subir</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal para confirmar eliminacion expediente-->
        <div id="deleteModal" class="modal">
            <form action="../models/create_carpeta.php" method="post" >
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2><i class="fa-solid fa-triangle-exclamation" style="margin-right: 25px; margin-bottom:25px"></i>
                    
                    Confirmar eliminación</h2>
                    <p>Esta acción eliminará el expediente y todos los documentos que contiene. ¿Estás seguro de que deseas continuar?</p>
                    <div class="form-actions">
                        <button id="confirmDelete" class="btn-delete" value="borrar_expediente">Eliminar</button>
                    </div>
                </div>
            </form> 
        </div>

        <!-- Modal para confirmar eliminacion documento-->
        <div id="deleteModal" class="modal">
           <form action="../models/create_carpeta.php" method="post" >
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2><i class="fa-solid fa-triangle-exclamation" style="margin-right: 25px; margin-bottom:25px"></i>
                    
                    Confirmar eliminación</h2>
                    <p>Esta acción eliminará el documento de forma permanente. ¿Estás seguro de que deseas continuar?</p>
                    <div class="form-actions">
                        <input type="hidden" name="documento_id" value="<?= $documento['id_documento'] ?>">
                        <button type="submit" id="confirmDelete" class="btn-delete" name="accion" value="borrar_documento">Eliminar</button>
                    </div>
                </div>
            </form> 
        </div>

        <!-- modal para editar expediente -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <form action="../models/create_carpeta.php" method="post">
                    <div id="titulo_carpeta_header">
                        <span class="close">&times;</span>
                        <h2>Editar expediente</h2>
                    </div>
                    <div id="input_carpeta">
                        <input type="hidden" name="id_expediente" id="edit_expediente_id">
                        <label for="nuevo_titulo">Título</label>
                        <input type="text" id="nuevo_titulo" name="nuevo_titulo" required>
                        
                        <label for="nueva_descripcion">Descripción</label>
                        <textarea id="nueva_descripcion" name="nueva_descripcion" required></textarea>
                    </div>
                    <div id="btn_carpeta">
                        <input type="hidden" name="accion" value="editar_expediente">
                        <button type="submit">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>

        <?php include 'logout.php'; ?>
    </main>
    
    <script src="../../public/js/auditor.js"></script>
    <script src="../../public/js/modal_carpeta.js"></script>
    <script src="../../public/js/modal_documento.js"></script>
</body>
</html>