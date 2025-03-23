<?php

require_once 'base_de_datos.php';


if ($conexion_metadocs->connect_error) {
    die("Conexión fallida: " . $conexion_metadocs->connect_error);
}

$sql = "SELECT usuarios.nombres, usuarios.correo, usuarios.rol, area_acceso.nombre AS area FROM usuarios JOIN area_acceso ON usuarios.id_area = area_acceso.id_area;";
$resultado = $conexion_metadocs->query($sql);
$stmt->close();
$conexion_metadocs->close();


?>