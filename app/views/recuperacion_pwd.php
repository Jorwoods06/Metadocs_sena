<?php
session_start();
$correo_inexistente = $_SESSION['no_existe'] ?? null;
unset($_SESSION['no_existe']); 



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="../../public/css/recuperacion_pwd.css">
  <link rel="icon" href="../../public/imagenes/logopng.png" type="image/x-icon">
</head>
<body>
  <div class="container">

    <h2>Recuperar contraseña</h2>
    <p>Ingresa la dirección de correo electrónico asociada a tu cuenta. Te enviaremos un mensaje con las instrucciones necesarias para restablecer tu contraseña.</p>
    <form action="../../app/controller/pwd.php" method="POST">
      <div class="input-group">
        <label for="pwd_input">Correo</label>
        <input type="text" id="pwd_input" name="pwd_input" required placeholder="ejemplo@gmail.com" class="<?= $correo_inexistente ? 'input-error' : '' ?>">
        <?php if ($correo_inexistente): ?>
        <div class="correo_inexistente" id="correo_inexistente" >
            <p><?= htmlspecialchars($correo_inexistente) ?></p>
        </div>
        <?php endif; ?>

      </div>
      <button type="submit">Enviar</button>
    </form>
    <p class="footer-text">
      ¿Recuerdas la contraseña? <a href="../../login.php">inicia sesión</a>
    </p>
  </div>
</body>
</html>
