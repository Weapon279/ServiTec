<?php
include 'conexion.php';

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCurso = $_POST['nombreCurso'];
    $docente = $_POST['docente'];
    $descripcion = $_POST['descripcion'];
    $modalidad = $_POST['modalidad'];
    $tipo = $_POST['tipo'];  
    $status = 'Falta Informacion'; 
    $claveGrupo = $_POST['claveGrupo'];
    $capacidad = $_POST['capacidad'];
    $costo = $_POST['costo'];
    $bstatus = '1';

    // Verificar si se ha subido un archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen']['name'];
        $target_dir = "img/";
        $imageFileType = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;

        // Verificar si el directorio existe, si no, crearlo
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Mover el archivo subido al directorio especificado
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            echo "El archivo ha sido subido exitosamente a: " . $target_file;
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
            $target_file = null;  // Establecer a null si hubo un error al mover el archivo
        }
    } else {
        echo "No se ha subido ninguna imagen o ha habido un error al subir la imagen.";
        $target_file = null;  // Establecer a null si no se sube imagen
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO curso (NombreCurso, DescripcionCurso, Modalidad, TipoSer, CostoCurso, ImagenCurso,  Status) 
            VALUES ('$nombreCurso', '$descripcion', '$modalidad', '$tipo',  '$costo','$target_file', '$status')";

    $sql = "INSERT INTO grupo (ClaveGrupo, Capacidad, Costo, FechaHoraC, Status) 
            VALUES ('$claveGrupo','$capacidad','$costo', NOW(),'$bstatus')"; 

$sql = "INSERT INTO convocatoria (DocenteConvoca, FechaHoraC, Status) 
            VALUES ('$docente', NOW(),'$bstatus')"; 
    
 
    if ($conn->query($sql) === TRUE) {
        $response["success"] = true;
        
        // Redirigir al usuario a "cursos.php" después de 5 segundos
        header("Refresh: 5; url=cursos.php");
        exit;
    } else {
        $response["error"] = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

echo json_encode($response);
?>