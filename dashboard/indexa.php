<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
}

$user_type_id = $_SESSION['userType'];
$username = $_SESSION['username'];

// Evitar que el usuario vuelva a la página anterior después de cerrar sesión
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Obtener el nombre del tipo de usuario
$query = "SELECT NombreTypeUser FROM typeuser WHERE id_TypeUser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_type_id);
$stmt->execute();
$result = $stmt->get_result();
$user_type = $result->fetch_assoc()['NombreTypeUser'];

// Función para generar el menú
function generateMenu($user_type_id, $conn) {
    $menu = "<ul class='nav nav-pills flex-column mb-auto'>";
    $query = "SELECT NombreTypeUser FROM typeuser WHERE id_TypeUser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_type = $result->fetch_assoc()['NombreTypeUser'];

    switch ($user_type) {
        case 'Admin':
            $menu .= "<li class='nav-item'><a href='dash.php' class='nav-link'><i class='fas fa-users'></i> Inicio</a></li>";
            $menu .= "<li class='nav-item'><a href='cursos.php' class='nav-link'><i class='fas fa-users'></i> Servicios</a></li>";
            $menu .= "<li class='nav-item'><a href='grupo.php' class='nav-link'><i class='fas fa-users'></i> Gestion de grupos</a></li>";
            $menu .= "<li class='nav-item'><a href='registro_taller.php' class='nav-link'><i class='fas fa-users'></i> Registro de Servicio</a></li>";
            $menu .= "<li class='nav-item'><a href='alumnos.php' class='nav-link'><i class='fas fa-users'></i> Alumnos</a></li>";
            $menu .= "<li class='nav-item'><a href='diplomas.php' class='nav-link'><i class='fas fa-users'></i> Diplomas</a></li>";
            break;
        case 'Alumno':
            $menu .= "<li class='nav-item'><a href='dashb.php' class='nav-link'><i class='fas fa-user-tie'></i>Inicio</a></li>";
            $menu .= "<li class='nav-item'><a href='registroc.php' class='nav-link'><i class='fas fa-file-invoice'></i> Registro de Servicio</a></li>";
            $menu .= "<li class='nav-item'><a href='a/diplomasa.php' class='nav-link'><i class='fas fa-user-tie'></i>Diplomas</a></li>";
            break;
        case 'Aspirante':
            $menu .= "<li class='nav-item'><a href='registroc.php' class='nav-link'><i class='fas fa-user-tie'></i> Registro de Servicio</a></li>";
            break;
    }
    $menu .= "</ul>";
    return $menu;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
    <style>
        html, body {font-family: "Raleway", sans-serif;}
    </style>
</head>
<body class="bg-light">

<!-- Top container -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SIGESEC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="notificaciones.php"><i class="fa fa-envelope"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=""><i class="fa fa-user"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-cog"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../cerrar.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
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
        <span class="fs-6">(<?php echo $user_type; ?>)</span>
    </a>
    <hr>
    <?php echo generateMenu($user_type_id, $conn); ?>
    <hr>
</div>

<!-- Add your page content here -->

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
