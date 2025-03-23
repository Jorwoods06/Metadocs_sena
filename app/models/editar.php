<?php
require_once '../models/base_de_datos.php';

if ($conexion_metadocs->connect_error) {
    die("Connection failed: " . $conexion_metadocs->connect_error);
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'edit':
                updateUser($conexion_metadocs);
                break;
            case 'delete':
                deleteUser($conexion_metadocs);
                break;
            default:
                echo json_encode(['success' => false, 'error' => 'Acción no válida']);
                break;
        }
    }
}

function updateUser($conexion) {
    $correo_original = $_POST['correo_original'];
    $nombre = $_POST['nombre'];
    $correo_nuevo = $_POST['correo'];
    $rol = $_POST['rol'];
    $area = $_POST['area'];
    
    // Primero obtener el id_area correspondiente
    $sql_area = "SELECT id_area FROM area_acceso WHERE nombre = ?";
    $stmt_area = $conexion->prepare($sql_area);
    $stmt_area->bind_param("s", $area);
    $stmt_area->execute();
    $result_area = $stmt_area->get_result();
    
    if ($row_area = $result_area->fetch_assoc()) {
        $id_area = $row_area['id_area'];
        
        // Ahora actualizar el usuario
        $sql = "UPDATE usuarios SET 
                nombres = ?, 
                correo = ?, 
                rol = ?, 
                id_area = ? 
                WHERE correo = ?";
                
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssis", $nombre, $correo_nuevo, $rol, $id_area, $correo_original);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conexion->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Área no encontrada']);
    }
    $stmt_area->close();
}

function deleteUser($conexion) {
    $correo = $_POST['correo'];
    
    $sql = "DELETE FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conexion->error]);
    }
    $stmt->close();
}

$conexion_metadocs->close();
?>