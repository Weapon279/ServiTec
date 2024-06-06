<?php include 'indexb.php'; ?>

<?php
session_start();
require 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['userId'];

// Consulta para obtener la información del usuario
$stmt = $pdo->prepare("
    SELECT u.vNombre, u.vApellidoP, u.vApellidoM, u.vCorreo, u.nWhats, u.iFechaHoraC, tu.NombreTypeUser 
    FROM user u
    JOIN typeuser tu ON u.Fk_TypeUser = tu.id_TypeUser
    WHERE u.id_User = :userId
");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el usuario, redirigir al login
if (!$usuario) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil del Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<body>

<div class="container mt-5">
    <h1 class="mb-4">Perfil del Usuario</h1>

    <table class="table table-bordered">
        <tr>
            <th>Nombre</th>
            <td><?php echo htmlspecialchars($usuario['vNombre']); ?></td>
        </tr>
        <tr>
            <th>Apellido Paterno</th>
            <td><?php echo htmlspecialchars($usuario['vApellidoP']); ?></td>
        </tr>
        <tr>
            <th>Apellido Materno</th>
            <td><?php echo htmlspecialchars($usuario['vApellidoM']); ?></td>
        </tr>
        <tr>
            <th>Correo Electrónico</th>
            <td><?php echo htmlspecialchars($usuario['vCorreo']); ?></td>
        </tr>
        <tr>
            <th>WhatsApp</th>
            <td><?php echo htmlspecialchars($usuario['nWhats']); ?></td>
        </tr>
        <tr>
            <th>Fecha de Creación</th>
            <td><?php echo htmlspecialchars($usuario['iFechaHoraC']); ?></td>
        </tr>
        <tr>
            <th>Tipo de Usuario</th>
            <td><?php echo htmlspecialchars($usuario['NombreTypeUser']); ?></td>
        </tr>
    </table>

    <a href="usuario.php" class="btn btn-primary">Volver al Panel de Usuario</a>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
