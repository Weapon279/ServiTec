<?php
include 'conexion.php';

// Obtener el nombre del archivo desde el parámetro de la URL
$archivo = isset($_GET['file']) ? $_GET['file'] : '';

// Ruta al directorio de PDFs
$directorio_pdf = 'pdf/';

// Ruta completa al archivo
$file = $directorio_pdf . basename($archivo);

// Verificar si el archivo existe
if (file_exists($file)) {
    // Definir los encabezados necesarios para la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Limpiar el búfer de salida
    flush();
    
    // Leer el archivo y enviarlo al navegador
    readfile($file);
    exit;
} else {
    echo 'El archivo no existe.';
}
?>
