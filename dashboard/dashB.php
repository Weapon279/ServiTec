<?php

include 'indexa.php';
require 'conexion.php';

// Obtener el ID del alumno (suponiendo que está almacenado en la sesión)
$studentId = $_SESSION['userId'] ?? null;

if (!$studentId) {
    echo "No se ha identificado al alumno.";
    exit; // Salir del script si no hay ID de alumno
}

$groupInfo = null;

// Consultar la información del grupo y curso en el que el alumno está inscrito
$sqlGroup = "
    SELECT grupo.*, curso.*
    FROM alumnos 
    JOIN grupo ON alumnos.Fk_Id_Grupo = grupo.id_Grupo
    JOIN curso ON grupo.Fk_id_Curso = curso.id_Curso
    WHERE alumnos.Fk_id_User = ?
";
$stmt = $conn->prepare($sqlGroup);
$stmt->bind_param('i', $studentId);
$stmt->execute();
$groupResult = $stmt->get_result();

if ($groupResult->num_rows > 0) {
    $groupInfo = $groupResult->fetch_assoc();

    // Comprobación de valores nulos antes de mostrar
    $nombreCurso = isset($groupInfo['NombreCurso']) ? htmlspecialchars($groupInfo['NombreCurso']) : "";
    $modalidad = isset($groupInfo['Modalidad']) ? htmlspecialchars($groupInfo['Modalidad']) : "";
    $descripcion = isset($groupInfo['DescripcionCurso']) ? htmlspecialchars($groupInfo['DescripcionCurso']) : "";
    $objetivo = isset($groupInfo['ObjectivoCurso']) ? htmlspecialchars($groupInfo['ObjectivoCurso']) : "";
    $conocimientos = isset($groupInfo['ConocimientosCurso']) ? htmlspecialchars($groupInfo['ConocimientosCurso']) : "";
    $contenido = isset($groupInfo['ContenidoCurso']) ? htmlspecialchars($groupInfo['ContenidoCurso']) : "";
    $docente = isset($groupInfo['DocenteConvoca']) ? htmlspecialchars($groupInfo['DocenteConvoca']) : "";
    $fechaInicio = isset($groupInfo['FechaI']) ? htmlspecialchars($groupInfo['FechaI']) : "";
    $fechaFin = isset($groupInfo['FechaF']) ? htmlspecialchars($groupInfo['FechaF']) : "";
    $capacidad = isset($groupInfo['Capacidad']) ? htmlspecialchars($groupInfo['Capacidad']) : "";
    $costo = isset($groupInfo['CostoCurso']) ? htmlspecialchars($groupInfo['CostoCurso']) : "";
    $status = isset($groupInfo['Status']) ? htmlspecialchars($groupInfo['Status']) : "";
}

$conn->close(); // Cerrar la conexión
?>

<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
    </style>
</head>
<body>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
    </header>

    <!-- Información del grupo y del curso -->
    <?php if ($groupInfo): ?>
        <div class="w3-container w3-card w3-white w3-margin-bottom">
            <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-book fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i> Información del Servicio</h2>
            <div class="w3-container">
                <h5 class="w3-opacity"><b>Nombre del Curso</b></h5>
                <p><?php echo $nombreCurso; ?></p>
                <h5 class="w3-opacity"><b>Modalidad</b></h5>
                <p><?php echo $modalidad; ?></p>
                <h5 class="w3-opacity"><b>Descripción</b></h5>
                <p><?php echo $descripcion; ?></p>
                <h5 class="w3-opacity"><b>Objetivo</b></h5>
                <p><?php echo $objetivo; ?></p>
                <h5 class="w3-opacity"><b>Conocimientos</b></h5>
                <p><?php echo $conocimientos; ?></p>
                <h5 class="w3-opacity"><b>Contenido</b></h5>
                <p><?php echo $contenido; ?></p>
                <h5 class="w3-opacity"><b>Docente</b></h5>
                <p><?php echo $docente; ?></p>
                <h5 class="w3-opacity"><b>Fecha de Inicio</b></h5>
                <p><?php echo $fechaInicio; ?></p>
                <h5 class="w3-opacity"><b>Fecha de Fin</b></h5>
                <p><?php echo $fechaFin; ?></p>
                <h5 class="w3-opacity"><b>Capacidad</b></h5>
                <p><?php echo $capacidad; ?></p>
                <h5 class="w3-opacity"><b>Costo</b></h5>
                <p><?php echo $costo; ?></p>
                <h5 class="w3-opacity"><b>Status</b></h5>
                <p><?php echo $status; ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="w3-container w3-card w3-white w3-margin-bottom">
            <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-info-circle fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i> No se encontró información del grupo</h2>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Función para abrir y cerrar el sidebar
    var mySidebar = document.getElementById("mySidebar");
    var overlayBg = document.getElementById("myOverlay");

    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }
</script>

</body>
</html>
