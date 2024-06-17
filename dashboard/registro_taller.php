<?php include 'conexion.php'; ?>
<?php include 'indexa.php'; ?>




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
            <label for="tipo" class="form-label">Tipo de servicio</label>
            <select class="form-select" id="tipo" name="tipo" required>
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
