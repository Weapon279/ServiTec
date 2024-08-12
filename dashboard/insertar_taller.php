<?php
include 'conexion.php';
include 'indexa.php';


$response = array("success" => false);
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    $nombreCurso = $_POST['nombreCurso'];
    $docente = $_POST['docente'];
    $descripcion = $_POST['descripcion'];
    $conocimientosCurso = $_POST['conocimientosCurso'];
    $contenidoCurso = $_POST['contenidoCurso'];
    $modalidad = $_POST['modalidad'];
    $tipo = $_POST['tipo'];
    $status = 'Falta Informacion';
    $claveGrupo = $_POST['claveGrupo'];
    $capacidad = $_POST['capacidad'];
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $costo = $_POST['costo'];
    $bstatus = '1';

    // Verificar si se ha subido una imagen
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

        // Verificar si se ha subido un archivo
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
            $imagen = $_FILES['pdf']['name'];
            $target_dir = "pdf/";
            $imageFileType = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
            $target_pdf = $target_dir . uniqid() . '.' . $imageFileType;
    
            // Verificar si el directorio existe, si no, crearlo
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
    
            // Mover el archivo subido al directorio especificado
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_pdf)) {
                echo "El archivo ha sido subido exitosamente a: " . $target_pdf;
            } else {
                echo "Lo siento, hubo un error al subir tu archivo.";
                $target_pdf = null;  // Establecer a null si hubo un error al mover el archivo
            }
        } else {
            echo "No se ha subido ninguna imagen o ha habido un error al subir la imagen.";
            $target_pdf = null;  // Establecer a null si no se sube imagen
        }

    // Insertar datos en la base de datos
    // Primero, insertar en la tabla `convocatoria`
    $sqlConvo = "INSERT INTO convocatoria (DocenteConvoca, FechaHoraC, Status) 
                 VALUES ('$docente', NOW(), '$bstatus')";

    if ($conn->query($sqlConvo) === TRUE) {
        $convocatoriaId = $conn->insert_id; // Obtener el ID de la convocatoria insertada
        
        // Insertar en la tabla `oferta`
        $sqlOferta = "INSERT INTO oferta (Fk_id_convoca, NombreOfer, Status, FechaHoraC, FechaHoraA) 
                      VALUES ('$convocatoriaId', '$nombreCurso', '$bstatus', NOW(), NOW())";
        
        if ($conn->query($sqlOferta) === TRUE) {
            $ofertaId = $conn->insert_id; // Obtener el ID de la oferta insertada

            // Insertar en la tabla `curso`
            $sqlCurso = "INSERT INTO curso (Fk_id_ofer, NombreCurso, DescripcionCurso, ConocimientosCurso, ContenidoCurso, Modalidad , TipoSer, CostoCurso, ImagenCurso , pdf, Status, FechaHoraC) 
                         VALUES ('$ofertaId', '$nombreCurso', '$descripcion', '$conocimientosCurso', ' $contenidoCurso ', '$modalidad', '$tipo', '$costo', '$target_file' , '$target_pdf', '$status', NOW())";

            if ($conn->query($sqlCurso) === TRUE) {
                $cursoId = $conn->insert_id;  // Obtener el ID del curso insertado






       
                    // Redirigir al usuario a "cursos.php" después de 3 segundos
                    header("Refresh: 1; url=cursos.php");
                    exit;
                } else {
                    $response["error"] = "Error: " . $conn->error;
                }
            } else {
                $response["error"] = "Error: " . $conn->error;
            }
        } else {
            $response["error"] = "Error: " . $conn->error;
        }
    } else {
        $response["error"] = "Error: " . $conn->error;
    }

    $conn->close();


echo json_encode($response);
?>
