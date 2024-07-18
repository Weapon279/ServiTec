<?php

require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['Nombre']) ? htmlspecialchars($_POST['Nombre']) : '';
    $email = isset($_POST['CorreoElectronico']) ? htmlspecialchars($_POST['CorreoElectronico']) : '';
    $asunto = isset($_POST['Asunto']) ? htmlspecialchars($_POST['Asunto']) : '';
    $mensaje = isset($_POST['Mensaje']) ? htmlspecialchars($_POST['Mensaje']) : '';

    if (!empty($nombre) && !empty($email) && !empty($asunto) && !empty($mensaje)) {
        $to = "a20220356@utem.edu.mx"; // Reemplaza con tu correo personal
        $subject = "Nuevo mensaje de contacto: $asunto";
        $body = "Nombre: $nombre\nCorreo: $email\n\nMensaje:\n$mensaje";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Mensaje enviado correctamente.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error al enviar el mensaje.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Todos los campos son obligatorios.'); window.location.href='index.php';</script>";
    }
}
?>
