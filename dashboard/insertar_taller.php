<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCurso = $_POST['nombreCurso'];
    $docente = $_POST['docente'];
    $descripcion = $_POST['descripcion'];
    $modalidad = $_POST['modalidad'];
    $costo = $_POST['costo'];

    // Verificar si se ha subido un archivo
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
        $imagen = $_FILES['imagen']['name'];
        $target_dir = "img/";
        $imageFileType = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;

        // Verificar si el directorio existe, si no, crearlo
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Mover el archivo subido al directorio especificado
        if(move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)){
            echo "El archivo ha sido subido exitosamente a: " . $target_file;
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    } else {
        echo "No se ha subido ninguna imagen o ha habido un error al subir la imagen.";
        $target_file = null;  // Establecer a null si no se sube imagen
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO curso (NombreCurso, DescripcionCurso, Modalidad, CostoCurso, ImagenCurso) VALUES ('$nombreCurso', '$descripcion', '$modalidad', '$costo', '$target_file')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
