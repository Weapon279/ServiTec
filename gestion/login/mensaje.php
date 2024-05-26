<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['Nombre']);
    $correo = htmlspecialchars($_POST['CorreoElectronico']);
    $asunto = htmlspecialchars($_POST['Asunto']);
    $mensaje = htmlspecialchars($_POST['Mensaje']);
    
    // Guardar los datos en un archivo de texto
    $data = "Nombre: $nombre\nCorreo: $correo\nAsunto: $asunto\nMensaje: $mensaje\n\n";
    file_put_contents('mensajes.txt', $data, FILE_APPEND);

    echo "Mensaje enviado correctamente.";
}

// Leer y mostrar los mensajes
$mensajes = file_get_contents('mensajes.txt');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mensajes Recibidos</title>
</head>
<body>
    <h3>Mensajes Recibidos</h3>
    <pre><?php echo $mensajes; ?></pre>
</body>
</html>
