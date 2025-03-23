<?php

require_once '../models/base_de_datos.php';


$token = $_GET['token'];

if ($token) {
  
    $stmt = $conexion_metadocs->prepare("SELECT id_usuario FROM contraseña_resets WHERE token = ? AND expira_en > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resetRequest = $result->fetch_assoc();
        $userId = $resetRequest['id_usuario'];

       
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../public/css/cambiar_pwd.css">
            <title>Recuperar Contraseña</title>
        </head>
        <body>
            <div class="contenedor" name="contenedor">
                <h2>Crea una nueva contraseña</h2>
                <p>Por favor, cree una contraseña nueva y fuerte para proteger su cuenta</p>
                <form action="../../app/models/cambio_contraseña.php" method="post">
                    <div class="inputs">
                        <label for="contraseña1">Nueva contraseña</label>
                        <input type="password" name="contraseña1" id="contraseña1" required placeholder="Ingresa una nueva contraseña" pattern=".{8,}" title="La contraseña debe tener al menos 8 caracteres">
                        <label for="contraseña2">Confirmar contraseña</label>
                        <input type="password" name="contraseña2" id="contraseña2" required placeholder="Confirma la contraseña">
                        <p class="error-message" id="errorMessage" style="display:none;">Las contraseñas no coinciden. Por favor, inténtalo de nuevo.</p>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <button type="submit">Cambiar contraseña</button>
                </form>
            </div>
            <script src="../../public/js/validar_contraseña.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "El enlace es inválido o ha expirado.";
    }
} else {
    echo "Falta el token en la URL.";
}
?>


