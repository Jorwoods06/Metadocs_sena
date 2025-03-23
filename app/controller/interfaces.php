<?php
session_start(); 






require_once '../models/base_de_datos.php';

if (isset($_POST['gmail']) && isset($_POST['password'])) {
    
    $correoIngresado = $_POST['gmail'];
    $contraseñaIngresada = md5($_POST['password']); 

    
    $stmt = $conexion_metadocs->prepare("SELECT * FROM `usuarios` WHERE correo=?");
    $stmt->bind_param("s", $correoIngresado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($datos = $result->fetch_object()) {
    
        
        if ($contraseñaIngresada === $datos->contraseña) {
            
            $rol = $datos->rol;
            $area = $datos ->id_area;
            
            
            $_SESSION['id_log'] =$id_usuario = $datos->id_usuario;
            $_SESSION['rol'] =$rol;
            $_SESSION['area'] =$area;
           
          


            switch ($rol) {
                case 'administrador':
                    header("Location: ../../app/views/admin.php");
                    break;
                case 'visualizador':
                    header("Location: visualizador.php");
                    break;
                case 'documentador':
                    header("Location: ../../app/views/documentador.php");
                    break;
                case 'auditor':
                    header("Location: ../../app/views/auditor.php");
                    break;
                default:
                    header("Location: index.html");
            }
            exit;
        } else {
            $_SESSION['error'] = 'contraseña incorrecta';
             header('Location: ../../login.php');
            exit();
        }
    } else {
        $_SESSION['denegado'] = 'Acceso denegado';
        header('Location: ../../login.php'); 
        exit();
    }
    
    $stmt->close();
}




$conexion_metadocs->close();



?>
