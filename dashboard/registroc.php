<?php
include 'conexion.php';
include 'indexa.php';

// Suponiendo que $usuario_id está definido en 'indexa.php'
$usuario_id = $_SESSION['userId'] ?? null;

// Configuración de paginación
$porPagina = 10; // Número de registros por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Obtener el número de página
$inicio = ($pagina - 1) * $porPagina;

// Contar el total de registros
$sqlCount = "SELECT COUNT(*) as total 
             FROM curso c 
             JOIN grupo g ON c.id_Curso = g.Fk_id_Curso 
             WHERE c.Status IN ('Disponible', 'Falta Informacion') 
             AND g.Status = 1"; // Asegurarse de que el grupo está activo
$resultCount = $conn->query($sqlCount);
$totalRegistros = $resultCount->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $porPagina);

// Consulta para obtener los registros paginados
$sql = "SELECT c.id_Curso, g.id_Grupo, c.NombreCurso, c.ObjectivoCurso, c.Modalidad, c.DescripcionCurso, c.CostoCurso, 
            g.FechaI, g.FechaF, g.Capacidad, g.Costo
        FROM curso c
        JOIN grupo g ON c.id_Curso = g.Fk_id_Curso
        WHERE c.Status IN ('Disponible', 'Falta Informacion')
        AND g.Status = 1
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $inicio, $porPagina);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['join_group'])) {
    $curso_id = $_POST['curso_id'];
    $grupo_id = $_POST['grupo_id'];

    $conn->begin_transaction();

    try {
        // Insertar el interés del aspirante en la tabla intereses con Status activo
        $sql = "INSERT INTO intereses (Fk_id_User, Fk_id_Curso, Fk_id_Grupo, Status, FechaHoraC) VALUES (?, ?, ?, 1, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuario_id, $curso_id, $grupo_id);
        $stmt->execute();

        // Enviar una notificación al administrador
        $mensaje = "Nuevo aspirante registrado para el curso ID: $curso_id en el grupo ID: $grupo_id";
        $tipo = "registro_grupo";
        $noti_sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (?, ?)";
        $noti_stmt = $conn->prepare($noti_sql);
        $noti_stmt->bind_param("ss", $tipo, $mensaje);
        $noti_stmt->execute();

        $conn->commit();
        // Marcamos que se debe mostrar el modal
        $mostrarModal = true;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al registrar el interés: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Aspirantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<!-- Margen de tabla y menu lateral -->
<div class="w3-main" style="margin-left:320px;margin-top:60px;">
<!--Fin de margen -->

<style>
/* Estilo para el modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Registro de Aspirantes</h1>
    <table class="table mt-5">
        <thead>
            <tr>
                <th>Nombre Curso</th>
                <th>Objectivo Curso</th>
                <th>Modalidad</th>
                <th>Descripción Curso</th>
                <th>Costo Curso</th>
                <th>Fecha Inicio Grupo</th>
                <th>Fecha Fin Grupo</th>
                <th>Capacidad del Grupo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['ObjectivoCurso']}</td>
                        <td>{$row['Modalidad']}</td>
                        <td>{$row['DescripcionCurso']}</td>
                        <td>{$row['CostoCurso']}</td>
                        <td>{$row['FechaI']}</td>
                        <td>{$row['FechaF']}</td>
                        <td>{$row['Capacidad']}</td>
                        <td>
                            <form method='POST' action='registroc.php'>
                                <input type='hidden' name='curso_id' value='{$row['id_Curso']}'>
                                <input type='hidden' name='grupo_id' value='{$row['id_Grupo']}'>
                                <button type='submit' name='join_group' class='btn btn-primary'>Unirse al Grupo</button>
                            </form>
                        </td>
                    </tr>";
            }
        ?>
        </tbody>
    </table>

    <!-- Controles de Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina < $totalPaginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

</body>
</html>
