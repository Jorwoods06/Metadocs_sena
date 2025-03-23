<?php
require_once '../../app/models/logout_bdd.php';

require_once '../helpers/verificar_rol.php';
checkAuthorization('administrador');


$exito = $_SESSION['exito'] ?? null;
unset($_SESSION['exito']);

$corre_exitente = $_SESSION['correo_existente'] ?? null;
unset($_SESSION['correo_existente']);
?>

<!DOCTYPE html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/admin.css">
    <link rel="stylesheet" href="../../public/css/admin_user.css">
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
                    <a href="../../app/views/admin.php" >
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
                        <li><a href="#" class="active">Crear usuario</a></li>
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
        <?php if ($exito): ?>
        <div class="mensaje_exito" id="mensaje-exito">
            <p><?= htmlspecialchars($exito) ?></p>
        </div>
    

        <?php endif; ?>

        <?php if ($corre_exitente): ?>
            <div class="correo_existente" id="correo_existente">
            <p><i class="fa-solid fa-circle-exclamation"></i><?= htmlspecialchars($corre_exitente) ?></p>
        </div>
        <?php endif; ?>

        <article id="panel_admin" class="panel_admin">
            <div class="container">
                <h1>Crear Usuario</h1>
                <p>Ingrese los datos del nuevo usuario</p>
                
                
                <form id="formulario_2" method="post" name="formulario_2" action="../../app/controller/formulario_registro.php">
                    <div class="form_info">
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ingrese nombre" required>
                        </div>
                        <div>
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" placeholder="Ingrese apellido" required>
                        </div>
                    </div>
                    <div class="form_correo">
                        <div>
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" placeholder="correo@ejemplo.com"  required class="<?= $corre_exitente ? 'input-error' : '' ?>" >
                        </div>
                        <div>
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" placeholder="Ingresa tu número telefónico" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <div>
                            <label for="cedula">Cédula</label>
                            <input type="number" id="cedula" name="cedula" placeholder="Ingresa tu cédula" required>
                        </div>
                    </div>
                    <div class="rol_area">
                        <div>
                            <label for="rol">Rol</label>
                            <select id="rol" name="rol" required>
                                <option value="#">Seleccione rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="auditor">Auditor</option>
                                <option value="documentador">Documentador</option>
                                <option value="visualizador">Visualizador</option>
                            </select>
                        </div>
                        <div>
                            <label for="area">Área</label>
                            <select id="area" name="area" required>
                                <option value="#">Seleccione área</option>
                                <option value="administracion">Administración</option>
                                <option value="logistica">Logística</option>
                                <option value="contabilidad">Contabilidad</option>
                                <option value="otro">Otro...</option>
                            </select>
                        </div>
                    </div>
                    <button id="boton_crear" type="submit">Crear Usuario</button>
                    
                </form>
            </div>
        </article>
        <?php include 'logout.php'; ?>
    </main>
    <script src="../../public/js/menuadmin.js"></script>

    
</body>
</html>


