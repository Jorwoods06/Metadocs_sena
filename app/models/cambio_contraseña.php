<?php

require_once 'base_de_datos.php';

session_start(); 
$email = $_SESSION['email'];

$token = $_POST['token'];
$nuevaContraseña = $_POST['contraseña2'];


$stmt = $conexion_metadocs->prepare("SELECT id_usuario FROM contraseña_resets WHERE token = ? AND expira_en > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $ContraseñaEncriptada = md5($nuevaContraseña);

   
    $stmt = $conexion_metadocs->prepare("UPDATE usuarios SET contraseña = ? WHERE correo = ?");
    $stmt->bind_param("ss", $ContraseñaEncriptada, $email);
    $stmt->execute();

    
    $stmt = $conexion_metadocs->prepare("DELETE FROM contraseña_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    header('Location: ../../app/views/pwd_exitoso.html');
    exit();
} else {
    echo "Token inválido o expirado.";
}


?>