<?php include '../indexa.php'; ?>

<?php
session_start();
require 'modelo/conexion.php';

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['userId'];

// Consulta para obtener el curso actual del usuario
$stmt = $pdo->prepare("
    SELECT c.NombreCurso, c.DuracionCurso, c.FechaHoraA 
    FROM curso c 
    JOIN user u ON u.id_User = :userId
    WHERE c.Fk_id_ofer = u.Fk_TypeUser
    ORDER BY c.FechaHoraA DESC 
    LIMIT 1
");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$cursoActual = $stmt->fetch(PDO::FETCH_ASSOC);

// Consulta para obtener los cursos de interés del usuario
$stmt = $pdo->prepare("
    SELECT c.NombreCurso 
    FROM curso c 
    WHERE c.Fk_id_ofer = (
        SELECT u.Fk_TypeUser 
        FROM user u 
        WHERE u.id_User = :userId
    )
    AND c.Status = 1
    LIMIT 5
");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$cursosInteres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los próximos cursos
$stmt = $pdo->prepare("
    SELECT NombreCurso, FechaHoraC 
    FROM curso 
    WHERE Status = 1 
    AND FechaHoraC > NOW()
    LIMIT 5
");
$stmt->execute();
$proximosCursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Usuario - Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<body>

    <div class="row">
        <!-- Curso Actual -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2>Curso Actual</h2>
                </div>
                <div class="card-body">
                    <?php if ($cursoActual): ?>
                        <p><strong>Curso:</strong> <?php echo $cursoActual['NombreCurso']; ?></p>
                        <p><strong>Duración:</strong> <?php echo $cursoActual['DuracionCurso']; ?></p>
                        <p><strong>Fecha de Actualización:</strong> <?php echo $cursoActual['FechaHoraA']; ?></p>
                    <?php else: ?>
                        <p>No estás inscrito en ningún curso actualmente.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Cursos de Interés -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2>Cursos de Interés</h2>
                </div>
                <div class="card-body">
                    <?php if ($cursosInteres): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cursosInteres as $curso): ?>
                                    <tr>
                                        <td><?php echo $curso['NombreCurso']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No tienes cursos de interés registrados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Próximos Cursos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2>Próximos Cursos</h2>
                </div>
                <div class="card-body">
                    <?php if ($proximosCursos): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Inicio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proximosCursos as $curso): ?>
                                    <tr>
                                        <td><?php echo $curso['NombreCurso']; ?></td>
                                        <td><?php echo $curso['FechaHoraC']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No hay próximos cursos disponibles en este momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
