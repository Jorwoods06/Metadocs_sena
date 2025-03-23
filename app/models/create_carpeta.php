<?php


require_once 'base_de_datos.php';

require_once '../helpers/area_usuario.php';

$area= $_SESSION['area'];
$area;



if ($conexion_metadocs->connect_error) {
    die("Connection failed: " . $conexion_metadocs->connect_error);
}

// Obtener todas las carpetas/expedientes
function obtenerCarpetas($conexion, $padre_id, $area) {
    if ($padre_id === 0) {
        $sql = "SELECT id_expediente, nombre, descripcion, fecha_creacion 
                FROM `expedientes` 
                WHERE (expediente_padre IS NULL OR expediente_padre = 0) 
                AND id_area = ?
                ORDER BY nombre";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $area);
        $stmt->execute();
        $resultado = $stmt->get_result();
    } else {
        $sql = "SELECT id_expediente, nombre, descripcion, fecha_creacion 
                FROM `expedientes` 
                WHERE expediente_padre = ?
                AND id_area = ?
                ORDER BY nombre";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $padre_id, $area);
        $stmt->execute();
        $resultado = $stmt->get_result();
    }
    return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
}
// Obtener documentos de una carpeta específica

function obtenerDocumentos($conexion, $padre_id, $area) {
    $sql = "SELECT id_documento, titulo, path, fecha_creacion, tipo 
            FROM documentos 
            WHERE id_expediente = ? 
            AND id_area = ?
            AND estado = 'aprobado' 
            AND estado_retencion = 'activo'
            ORDER BY fecha_creacion DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $padre_id, $area);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
}

// Función para obtener información de una carpeta específica
function obtenerInfoCarpeta($conexion, $id_expediente) {
    $sql = "SELECT id_expediente, nombre, descripcion, fecha_creacion 
            FROM expedientes 
            WHERE id_expediente = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_expediente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado ? $resultado->fetch_assoc() : false;
}

// Crear una nueva carpeta
function crearCarpeta($conexion, $nombre, $descripcion, $padreId, $area) {
    $sql_carpeta = $conexion->prepare("INSERT INTO expedientes (nombre, descripcion, expediente_padre,id_area) VALUES (?, ?, ?,?)");
    
    if ($sql_carpeta) {
        $sql_carpeta->bind_param("ssii", $nombre, $descripcion, $padreId,$area);
        return $sql_carpeta->execute();
    } else {
        die("Error al preparar la consulta: " . $conexion->error);
    }
}

// Subir un documento


function subirDocumento($conexion, $archivo, $id_expediente, $area, $id_usuario, $estado , $estado_retencion , $categoria, $fin_retencion) {
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    
    // hayar retencion 
    $sql_buscar_categoria = "SELECT id_retencion FROM retencion WHERE categoria = ?";
    $stmt_categoria = $conexion->prepare($sql_buscar_categoria);
    $stmt_categoria ->bind_param("s",$categoria);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();

    if ($resultado_categoria->num_rows === 0) {
        $_SESSION['error_categoria'] = "Categoria invalida";
        header("Location: ../views/auditor_doc.php?error=upload_failed&id_expediente=" . $id_expediente);
        exit();
    }

    $id_retencion = $resultado_categoria->fetch_assoc()['id_retencion'];

    //calcular fin retencion

    $sql_finRetencion = "SELECT DATE_ADD(CURDATE(), INTERVAL (duracion_año * 12 + duracion_mes) MONTH) AS fecha_retencion FROM retencion WHERE id_retencion = ?;";
    $stmt_finRetencion = $conexion->prepare($sql_finRetencion);
    $stmt_finRetencion -> bind_param("i",$id_retencion);
    $stmt_finRetencion->execute();
    $resultado_retencion = $stmt_finRetencion->get_result();
    $fila_retencion = $resultado_retencion->fetch_assoc();
    $fin_retencion = $fila_retencion['fecha_retencion'];
   

    // Asegurar que el estado sea válido
    if (!in_array($estado, ["aprobado", "revision"])) {
        $estado = "aprobado"; 
        $estado_retencion ="activo";
    }

    // Iniciar transacción para asegurar que ambas operaciones se completen
    $conexion->begin_transaction();

    try {
        // Definir directorio de subida
        $directorio = "../uploads/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Generar nombre único para evitar sobrescribir archivos
        $nombre_archivo = uniqid() . '_' . basename($archivo["name"]);
        $nombre_base = pathinfo($archivo["name"], PATHINFO_FILENAME);
        $rutaArchivo = $directorio . $nombre_archivo;

        // Validar la extensión del archivo
        $tipos_permitidos = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
        if (!in_array($extension, $tipos_permitidos)) {
            return false;
        }





        if (move_uploaded_file($archivo["tmp_name"], $rutaArchivo)) {
            // Insertar el documento
            $sql = $conexion->prepare("INSERT INTO documentos (titulo, path, id_expediente, id_area, tipo, autor,estado,estado_retencion,id_retencion,fin_retencion) VALUES (?, ?, ?, ?, ?,?,?,?,?,?)");
            $titulo =  $nombre_base;
            $tipo = $extension;
            
            $sql->bind_param("ssiisissss", $titulo, $rutaArchivo, $id_expediente, $area, $tipo, $id_usuario, $estado, $estado_retencion,$id_retencion,$fin_retencion);
            $documento_insertado = $sql->execute();

            // Si ambas operaciones fueron exitosas, confirmar la transacción
            if ($documento_insertado) {
                $conexion->commit();
                return true;
            } else {
                // Si algo falló, revertir los cambios
                $conexion->rollback();
                return false;
            }
        }
        
        // Si no se pudo mover el archivo, revertir la transacción
        $conexion->rollback();
        return false;

    } catch (Exception $e) {
        // Si ocurre algún error, revertir la transacción
        $conexion->rollback();
        return false;
    }
}

function borrarDocumento($conexion, $documento_id) {
    // Obtener la información del documento antes de borrarlo
    $sql = "SELECT path, id_expediente FROM documentos WHERE id_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $documento_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $documento = $resultado->fetch_assoc();

    if ($documento) {
        $filePath = $documento['path'];

        // Verificar si el archivo existe antes de eliminarlo
        if (file_exists($filePath)) {
            if (!unlink($filePath)) {
                error_log("Error al eliminar el archivo: " . $filePath);
                return false;
            }
        }

        // Eliminar el registro de la base de datos
        $sql = "DELETE FROM documentos WHERE id_documento = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $documento_id);
        $resultado = $stmt->execute();
        
        // Si se borró exitosamente, retornar el id_expediente
        if ($resultado) {
            return $documento['id_expediente'];
        }
    }
    return false;
}

function descargarDocumento($conexion, $documento_id) {
    // Preparar la consulta para obtener la información del documento
    $sql = "SELECT d.titulo, d.path, d.tipo, e.nombre as nombre_expediente 
            FROM documentos d 
            LEFT JOIN expedientes e ON d.id_expediente = e.id_expediente 
            WHERE d.id_documento = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $documento_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $documento = $resultado->fetch_assoc();

    if (!$documento || !file_exists($documento['path'])) {
        return false;
    }

    // Limpiar el buffer de salida
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Determinar el tipo MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $documento['path']);
    finfo_close($finfo);

    // Preparar el nombre del archivo para la descarga
    $nombreArchivo = $documento['titulo'];
    
    // Configurar las cabeceras para la descarga
    header('Content-Type: ' . $mimeType);
    header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    header('Content-Length: ' . filesize($documento['path']));
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Leer y enviar el archivo en bloques para manejar archivos grandes
    $handle = fopen($documento['path'], 'rb');
    while (!feof($handle)) {
        echo fread($handle, 8192);
        flush();
    }
    fclose($handle);
    exit;
}

function editarExpediente($conexion, $id_expediente, $nuevo_titulo, $nueva_descripcion) {
    try {
        // Obtener el expediente_padre antes de editar
        $sql_parent = "SELECT expediente_padre FROM expedientes WHERE id_expediente = ?";
        $stmt_parent = $conexion->prepare($sql_parent);
        $stmt_parent->bind_param("i", $id_expediente);
        $stmt_parent->execute();
        $result = $stmt_parent->get_result();
        $expediente = $result->fetch_assoc();
        $expediente_padre = $expediente['expediente_padre'];

        // Preparar la consulta SQL para actualizar
        $sql = "UPDATE expedientes 
                SET nombre = ?, 
                    descripcion = ?
                WHERE id_expediente = ?";
        
        $stmt = $conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $conexion->error);
        }
        
        // Vincular los parámetros
        $stmt->bind_param("ssi", $nuevo_titulo, $nueva_descripcion, $id_expediente);
        
        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando la consulta: " . $stmt->error);
        }
        
        // Verificar si se actualizó algún registro
        if ($stmt->affected_rows > 0 || $stmt->affected_rows === 0) {
            // Retornar tanto el éxito como el id del padre para la redirección
            return [
                'success' => true,
                'expediente_padre' => $expediente_padre
            ];
        } else {
            throw new Exception("El expediente no existe");
        }
    } catch (Exception $e) {
        error_log("Error en editarExpediente: " . $e->getMessage());
        return [
            'success' => false,
            'expediente_padre' => null
        ];
    }
}


// Manejo de formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'crear_carpeta':
                $nombre = $_POST['titulo_carpeta'];
                $descripcion = $_POST['desc_carpeta'];
                $padreId = $_POST['expediente_padre'] ?? 0;
            
                if (crearCarpeta($conexion_metadocs, $nombre, $descripcion, $padreId, $area)) {
                    header("Location: ../views/auditor_doc.php?success=true&id_expediente=" . $padreId);
                } else {
                    header("Location: ../views/auditor_doc.php?error=true&id_expediente=" . $padreId);
                }
                exit;

                case 'subir_documento':
                    $id_expediente = $_POST['expediente_id'];
                    $archivo = $_FILES['file-input'];
                    $categoria = $_POST['categoria'];
                   
                
                    if (subirDocumento($conexion_metadocs, $archivo, $id_expediente, $area, $id_usuario, $estado, $estado_retencion, $categoria,$fin_retencion)) {
                        $_SESSION['doc_exito'] = 'Documento subido con éxito';
                        header("Location: ../views/auditor_doc.php?success=true&id_expediente=" . $id_expediente);
                    } else {
                        header("Location: ../views/auditor_doc.php?error=upload_failed&id_expediente=" . $id_expediente);
                    }
                    exit;

                case 'borrar_documento':
                    if (isset($_POST['documento_id'])) {
                        $id_expediente = borrarDocumento($conexion_metadocs, $_POST['documento_id']);
                        if ($id_expediente) {
                            header("Location: ../views/auditor_doc.php?success=true&id_expediente=" . $id_expediente);
                        } else {
                            header("Location: ../views/documenter_doc.php?error=upload_failed");
                        }
                        exit();
                    }
                    break;

                case 'descargar_documento':
                     if (isset($_POST['documento_id'])) {
                            descargarDocumento($conexion_metadocs, $_POST['documento_id']);
                        }
                    break;

                    case 'editar_expediente':
                        if (isset($_POST['id_expediente']) && isset($_POST['nuevo_titulo']) && isset($_POST['nueva_descripcion'])) {
                            $id_expediente = $_POST['id_expediente'];
                            $nuevo_titulo = $_POST['nuevo_titulo'];
                            $nueva_descripcion = $_POST['nueva_descripcion'];
                            
                            $resultado = editarExpediente($conexion_metadocs, $id_expediente, $nuevo_titulo, $nueva_descripcion);
                            
                            if ($resultado['success']) {
                                // Si el expediente tiene un padre, redirigir a la vista de ese padre
                                if ($resultado['expediente_padre']) {
                                    header("Location: ../views/auditor_doc.php?id_expediente=" . $resultado['expediente_padre']);
                                } else {
                                    // Si no tiene padre, redirigir a la vista principal
                                    header("Location: ../views/auditor_doc.php");
                                }
                            } else {
                                header("Location: ../views/auditor_doc.php?error=edit_failed&id_expediente=" . $id_expediente);
                            }
                            exit;
                        }
                        break;
                
        }
    }

}



