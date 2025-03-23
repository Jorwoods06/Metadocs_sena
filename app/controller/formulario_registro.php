<?php
session_start();
require_once '../models/base_de_datos.php';

if ($conexion_metadocs->connect_error) {
    die("Conexión fallida: " . $conexion_metadocs->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $contraseña = isset($_POST['password']) ? md5(trim($_POST['password'])) : '';
    $cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $rol = isset($_POST['rol']) ? trim($_POST['rol']) : '';
    $area = isset($_POST['area']) ? trim($_POST['area']) : '';

    // Validar campos vacíos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($telefono) || empty($contraseña) || empty($cedula) || empty($rol) || empty($area)) {
        die("Por favor complete todos los campos.");
    }

    // Iniciar transacción
    $conexion_metadocs->begin_transaction();

    try {
        // Verificar si el correo ya está registrado
        $sql_verificar_email = "SELECT correo FROM usuarios WHERE correo = ?";
        $stmt = $conexion_metadocs->prepare($sql_verificar_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
           
            $_SESSION['correo_existente'] = "El correo electrónico ya está registrado.";
            header('Location: ../../app/views/admin_user.php');
            exit();
        }

        // Buscar el ID del área
        $sql_buscar_area = "SELECT id_area FROM area_acceso WHERE nombre = ?";
        $stmt_area = $conexion_metadocs->prepare($sql_buscar_area);
        $stmt_area->bind_param("s", $area);
        $stmt_area->execute();
        $resultado_area = $stmt_area->get_result();

        if ($resultado_area->num_rows === 0) {
            // Área no encontrada
            $_SESSION['error'] = "El área especificada no existe.";
            header('Location: ../../app/views/admin_user.php');
            exit();
        }

        $id_area = $resultado_area->fetch_assoc()['id_area'];

     
        $sql_usuario = "INSERT INTO usuarios (nombres, apellidos, correo, contraseña, cedula, telefono, rol, id_area) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt_usuario = $conexion_metadocs->prepare($sql_usuario);
        $stmt_usuario->bind_param("sssssssi", $nombre, $apellido, $email, $contraseña, $cedula, $telefono, $rol, $id_area);
        $stmt_usuario->execute();

       
        $conexion_metadocs->commit();
        $_SESSION['exito'] = 'Usuario creado con éxito';
        header('Location: ../../app/views/admin_user.php');
        exit();
    } catch (Exception $e) {
        
        $conexion_metadocs->rollback();
        $_SESSION['error'] = "Error al registrar los datos: " . $e->getMessage();
        header('Location: ../../app/views/admin_user.php');
        exit();
    }

    $conexion_metadocs->close();
}
