<?php
session_start(); 

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    
    echo "No se encontró un correo asociado con esta sesión.";
    exit;
}

$reenvio = $_SESSION['reenvio'] ?? null;
unset($_SESSION['reenvio']);



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../../public/css/correo_enviado.css">
    <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo enviado</title>
</head>
<body>
    <main id="cuerpo">
    <?php if ($reenvio): ?>
        <div class="reenvio_exito" id="reenvio_exito">
            <p><?= htmlspecialchars($reenvio) ?></p>
        </div>
        <?php endif; ?>
        <div id="contenedor" name="contenedor">
            <div id="titulo" name="titulo">
                <h2>Correo enviado</h2>
                <p>Hemos enviado un correo a <span class="resaltar"><?php echo $email; ?></span>, por favor, revisa tu bandeja de entrada para encontrar las instrucciones necesarias para restablecer tu contraseña.</p>
            </div>
            <div class="vinculos" name="vinculos">
            <p>¿No recibiste un correo?<a href="../../app/controller/reenviar_correo.php"> Reenviar</a></p>

            </div>
            <div class="vinculos" name="vinculos">
                <p>¿Correo incorrecto?<a href="../../app/views/recuperacion_pwd.php"> Cambiar correo</a></p>
            </div>
        </div>
    </main>
</body>
</html>
