<?php include 'conexion.php'; ?>
<?php include 'indexa.php'; ?>
<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreCurso = $_POST['nombreCurso'];
    $docente = $_POST['docente'];
    $descripcion = $_POST['descripcion'];
    $modalidad = $_POST['modalidad'];
    $tipo = $_POST['tipo'];
    $costo = $_POST['costo'];
    $imagen = $_FILES['imagen']['name'];
    $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
    $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;

    $targetDir = "img/";
    $targetFile = $targetDir . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile);

    $status = 'Disponible';
    if (empty($fechaInicio) || empty($fechaFin)) {
        $status = 'Falta Informacion';
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO curso (Fk_id_ofer, NombreCurso, NombreDoc, DescripcionCurso, Modalidad, CostoCurso, ImagenCurso, FechaHoraC, FechaHoraA, Status, TipoSer) 
                VALUES (NULL, :nombreCurso, :docente, :descripcion, :modalidad, :costo, :imagen, :fechaInicio, :fechaFin, :status, 'Curso')";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreCurso', $nombreCurso);
        $stmt->bindParam(':docente', $docente);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':modalidad', $modalidad);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':imagen', $targetFile);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        echo "Curso registrado con éxito.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html>
<head>
<title>DashBoard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<div class="container mt-5">
    <h2>Registrar Servicio</h2>
    <form action="insertar_taller.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombreCurso" class="form-label">Nombre del Servicio</label>
            <input type="text" class="form-control" id="nombreCurso" name="nombreCurso" required>
        </div>
        <div class="mb-3">
            <label for="docente" class="form-label">Docente</label>
            <input type="text" class="form-control" id="docente" name="docente" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="modalidad" class="form-label">Modalidad</label>
            <select class="form-select" id="modalidad" name="modalidad" required>
                <option value="Virtual">Virtual</option>
                <option value="Presencial">Presencial</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de curso</label>
            <select class="form-select" id="modalidad" name="modalidad" required>
                <option value="Curso">Curso</option>
                <option value="Taller">Taller</option>
                <option value="Servicio Tecnologico">Servicio Tecnologico</option>

            </select>
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="number" class="form-control" id="costo" name="costo" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del Curso</label>
            <input type="file" class="form-control" id="imagen" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
