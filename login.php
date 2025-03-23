<?php
session_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']); 

$denegado = $_SESSION['denegado'] ?? null;
unset($_SESSION['denegado']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar | Metadocs</title>
    <link rel="stylesheet" href="public/css/log.css">
    <link rel="icon" href="public/imagenes/logopng.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <main id="cuerpo" role="main"> 
        <div id="cont_img">
            <figure id="figure_img">
               <img src="public/imagenes/OIG2 (1).jpeg" alt="Imagen decorativa de bienvenida">
            </figure>
        </div>

        <div id="form">
            <form id="formulario" method="post" action="app/controller/interfaces.php" novalidate>
                <div id="logo">
                    <figure id="logotipo">
                        <img src="public/imagenes/image.png" alt="Logo de Metadocs">
                        <p>Logeate para iniciar</p>
                    </figure>
                </div>

                <div class="input_login">
                    <label for="gmail">Gmail</label>
                    <input 
                        type="email" 
                        id="gmail" 
                        name="gmail" 
                        placeholder="Ingresa tu correo" 
                        required 
                        autocomplete="email"
                        aria-required="true"
                        class="<?= $denegado ? 'input-error' : '' ?>"
                        aria-invalid="<?= $denegado ? 'true' : 'false' ?>"
                        aria-describedby="<?= $denegado ? 'gmail-error' : '' ?>"
                    >
                    <?php if ($denegado): ?>
                        <p class="error-message" id="gmail-error" role="alert"><?= htmlspecialchars($denegado) ?></p>
                    <?php endif; ?>
                </div>

               

                <div class="input_login">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Ingresa tu contraseña" 
                        required 
                        autocomplete="current-password"
                        aria-required="true"
                        class="<?= $error ? 'input-error' : '' ?>"
                        aria-invalid="<?= $error ? 'true' : 'false' ?>"
                        aria-describedby="<?= $error ? 'password-error' : '' ?>"
                    >
                    <?php if ($error): ?>
                        <p class="error-message" id="password-error" role="alert"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                </div>

              

                <div id="recordar">
                    <div class="checkbox-container">
                        <input type="checkbox" id="recordatorio" name="recordatorio">
                        <label for="recordatorio">Recordar</label>
                    </div>
                    <a href="app/views/recuperacion_pwd.php">¿Olvidaste tu contraseña?</a>
                </div>

           
                

                <div id="boton">
                    <button type="submit" aria-label="Iniciar sesión">Iniciar</button>    
                </div>
            </form>
        </div>
    </main>

    <script src="public/js/desactivar_btn.js"></script>
</body>
</html>