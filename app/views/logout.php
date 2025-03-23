
<?php
require_once '../models/logout_bdd.php';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/logout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>

<div id="cerrar_sesion" >
            <div id="datos_user">
                <h3><?php echo htmlspecialchars($usuario['nombres'] ?? 'Usuario'); ?></h3>
                <p><?php echo htmlspecialchars($usuario['correo'] ?? 'ejemplo@gmail.com'); ?></p>
            </div>
            <div id="opciones_sesion">
                <ul>
                  
                        <li><button><i class="fa-regular fa-circle-question"></i>Información del usuario</button></li>
                    <form action="../controller/cerrar_sesion.php" method="post">
                        <li class="logout" id="close_sesion"><button><i class="fa-solid fa-arrow-right-from-bracket"></i>Cerrar sesión</button></li>
                    </form>
                </ul>
            </div>
        </div>

</body>
</html>