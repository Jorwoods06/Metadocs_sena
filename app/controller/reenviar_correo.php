<?php
session_start();
require '../../config/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Configuración PHPMailer
    $mail = new PHPMailer(true);

    try {
        $link = "http://localhost/metadocs_v1/app/views/form_correo.php?token=tu_token_aqui"; // Asegúrate de generar un token válido.

        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'metadocs7@gmail.com';
        $mail->Password = 'ajut qrux zvaa dqls';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@metadocs.com', 'Metadocs');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reenvío de recuperación de contraseña';
        $mail->Body = "Haz clic en este enlace para restablecer tu contraseña: <a href='$link'>$link</a><br><br>Este enlace expirará en una hora.";
        $mail->AltBody = "Haz clic en este enlace para restablecer tu contraseña: $link\n\nEste enlace expirará en una hora.";

        // Enviar correo
        $mail->send();

        $_SESSION['reenvio'] = 'El correo ha sido reenviado correctamente';
        header('Location: ../../app/views/correo_enviado.php'); 
        exit();

    } catch (Exception $e) {
        echo "Hubo un problema al reenviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No se encontró un correo asociado con esta sesión.";
}
?>
