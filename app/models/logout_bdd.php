<?php
// Verificar si no hay una sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_log'])) {
    header('Location: ../../login.php');
    exit();
}

// Conectar a la base de datos
require_once 'base_de_datos.php';

// Obtener datos del usuario
$id_usuario = $_SESSION['id_log'];
$stmt = $conexion_metadocs->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();


?>