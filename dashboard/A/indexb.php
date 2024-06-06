
<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
}

$userType = $_SESSION['userType'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        html, body {font-family: "Raleway", sans-serif;}
    </style>
</head>
<body class="bg-light">

<!-- Top container -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="mensaje.php"><i class="fa fa-envelope"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cerrar.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar/menu -->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 280px; height: 100vh; position: fixed; top: 56px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <img src="/w3images/avatar2.png" class="rounded-circle me-2" alt="Avatar" width="48" height="48">
        <span class="fs-4">Bienvenido, <strong><?php echo $_SESSION['username']; ?></strong></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="usuario.php" class="nav-link <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
                <i class="fa fa-home"></i> Inicio
            </a>
        </li>
        <li>
            <a href="perfila.php" class="nav-link <?php echo $page == 'courses' ? 'active' : ''; ?>">
                <i class="fa fa-book"></i> Perfil
            </a>
        </li>
        <li>
            <a href="diplomasa.php" class="nav-link <?php echo $page == 'diplomas' ? 'active' : ''; ?>">
                <i class="fa fa-trophy"></i> Diplomas
            </a>
        </li>
    </ul>
</div>

</body>
</html>
