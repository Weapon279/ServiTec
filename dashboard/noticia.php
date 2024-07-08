<?php
include 'indexa.php';
include 'conexion.php';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Insertar Noticia</title>
</head>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Insertar Noticia</h1>

        <!-- Formulario para ingresar nueva noticia -->
        <form method="POST" action="guardar_noticia.php">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la noticia</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido de la noticia</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Noticia</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
