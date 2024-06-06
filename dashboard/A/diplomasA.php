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

// Consulta para obtener los diplomas del usuario
$stmt = $pdo->prepare("
    SELECT NombreDiploma, LinkDiploma, FechaHoraC 
    FROM diplomas 
    WHERE Fk_id_user = :userId
");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$diplomas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Margen de tabla y menu lateral -->
<div class="w3-main" style="margin-left:320px;margin-top:60px;">
<!--Fin de margen -->

<!DOCTYPE html>
<html>
<head>
    <title>Diplomas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="container-fluid">
    <div class="col-md-9">
        <h1 class="mt-4">Diplomas</h1>
        <div class="card my-4">
            <div class="card-header">
                Lista de Diplomas
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Diploma</th>
                            <th>Fecha de Obtención</th>
                            <th>Enlace</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($diplomas): ?>
                            <?php foreach ($diplomas as $diploma): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($diploma['NombreDiploma']); ?></td>
                                    <td><?php echo htmlspecialchars($diploma['FechaHoraC']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($diploma['LinkDiploma']); ?>" target="_blank">Ver Diploma</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No tienes diplomas disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
