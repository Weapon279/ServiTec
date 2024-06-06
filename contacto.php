<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['Nombre'];
    $correo = $_POST['CorreoElectronico'];
    $asunto = $_POST['Asunto'];
    $mensaje = $_POST['Mensaje'];

    $to = "a20220356@utem.edu.mx";
    $subject = "Nuevo mensaje de contacto: " . $asunto;
    $body = "Nombre: $nombre\nCorreo Electrónico: $correo\nAsunto: $asunto\nMensaje:\n$mensaje";
    $headers = "From: $correo";

    if (mail($to, $subject, $body, $headers)) {
        echo "Mensaje enviado exitosamente.";
    } else {
        echo "Hubo un error al enviar el mensaje.";
    }
} else {
    header('Location: '); 
}
?>
