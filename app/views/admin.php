<?php
require_once '../helpers/verificar_rol.php';
checkAuthorization('administrador');
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
</head>
<body>
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

    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <ul>
                <li>
                    <a href="#" class="active">
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
                        <li><a href="../../app/views/admin_view.php">Ver usuario</a></li>
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
            <h1>Panel de Control</h1>
            <p>Este es el contenido principal del panel de administración.</p>
        </article>
        
        <?php include 'logout.php'; ?>
    </main>
    
    <script src="../../public/js/menuadmin.js"></script>
</body>
</html>
