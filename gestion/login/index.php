<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
.w3-green-custom {
    background-color: var(--color-verde-azulado) !important;
}
</style>
<body>
    
    <nav class="navbar navbar-expand-lg w3-green-custom bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cursos.php">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro_taller.php">Registro de Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alumnos.php">Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diplomas.php">Diplomas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Bienvenido al Dashboard Administrativo</h1>
        <p>Seleccione una sección del menú para comenzar.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
