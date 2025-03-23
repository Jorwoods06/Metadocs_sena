<?php
require_once '../helpers/verificar_rol.php';
checkAuthorization('auditor');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
    <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/auditor.css">
    
</head>
<body>
    <!-- Header -->
    <header id="cabeza">
        <figure id="logo">
            <img src="../../public/imagenes/image.png" alt="logo">
        </figure>
        <div class="menu-toggle" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <nav id="iconos">
            <ul>
                <li>
                    <button type="submit" id="btn_sesion">
                        <i class="fa-solid fa-circle-user"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Cuerpo -->
    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <ul>

               


                <li>
                    <a href="#" class="active">
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
                        <li><a href="./../views/auditor_doc.php" id="gestion-documentos">Ver documentos</a></li>
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
            <h1>Inicio</h1>
            <p>Este es el contenido principal del usuario documentador.</p>
        </article>
        <?php include 'logout.php'; ?>
    </main>
    <script src="../../public/js/auditor.js"></script>
    
</body>
</html>
