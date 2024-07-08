<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Comprobar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    // Escapar caracteres especiales si es necesario
    $titulo = htmlspecialchars($titulo);
    $contenido = htmlspecialchars($contenido);

    // Insertar la noticia en la base de datos
    $sql = "INSERT INTO noticias (titulo, contenido) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $titulo, $contenido);

    if ($stmt->execute()) {
        // Redirigir de vuelta a noticia.php después de guardar la noticia
        header("Location: noticia.php");
        exit();
    } else {
        echo "Error al intentar guardar la noticia: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
