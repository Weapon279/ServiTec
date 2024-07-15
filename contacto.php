
<?php

require 'modelo/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    $to = "a20220356@utem.edu.mx"; // Reemplaza con tu correo personal
    $subject = "Nuevo mensaje de contacto: $asunto";
    $body = "Nombre: $nombre\nCorreo: $email\n\nMensaje:\n$mensaje";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Mensaje enviado correctamente.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje.'); window.location.href='index.php';</script>";
    }

}
?>
