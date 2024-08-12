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
$sql = "SELECT c.id_Curso, g.id_Grupo, c.NombreCurso, c.ObjectivoCurso, c.Modalidad, 
               c.DescripcionCurso, c.CostoCurso, g.FechaI, g.FechaF, g.Capacidad, g.Costo, 
               c.ConocimientosCurso, c.ContenidoCurso, c.pdf
        FROM curso c
        JOIN grupo g ON c.id_Curso = g.Fk_id_Curso
        WHERE c.Status IN ('Disponible', 'Falta Informacion')
        AND g.Status = 1
        LIMIT ?, ?";

$conocimientosCurso = isset($_POST['ConocimientosCurso']) ? $_POST['ConocimientosCurso'] : '';
$contenidoCurso = isset($_POST['ContenidoCurso']) ? $_POST['ContenidoCurso'] : '';

// Asegúrate de que la ruta se genere correctamente incluso si la columna `pdf` está vacía
$pdf = isset($row['pdf']) && !empty($row['pdf']) ? "pdf/{$row['pdf']}" : "#";
$pdfFilename = basename($pdf); // Nombre del archivo PDF



$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $inicio, $porPagina);
$stmt->execute();
$result = $stmt->get_result();

$mostrarModal = false;
$mensajeModal = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['join_group'])) {
    $curso_id = $_POST['curso_id'];
    $grupo_id = $_POST['grupo_id'];

    // Verificar si el usuario ya está registrado en el grupo
    $sqlVerificar = "SELECT * FROM intereses WHERE Fk_id_User = ? AND Fk_id_Curso = ? AND Fk_id_Grupo = ?";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->bind_param("iii", $usuario_id, $curso_id, $grupo_id);
    $stmtVerificar->execute();
    $resultadoVerificar = $stmtVerificar->get_result();

    if ($resultadoVerificar->num_rows > 0) {
        // Usuario ya está registrado en el grupo
        $mostrarModal = true;
        $mensajeModal = "Ya estás registrado en el grupo.";
    } else {
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
            $noti_sql = "INSERT INTO notificaciones (Fk_id_User, Tipo, Mensaje) VALUES ($usuario_id, ?, ?)";
            $noti_stmt = $conn->prepare($noti_sql);
            $noti_stmt->bind_param("ss", $tipo, $mensaje);
            $noti_stmt->execute();

            $conn->commit();
            // Marcamos que se debe mostrar el modal
            $mostrarModal = true;
            $mensajeModal = "Solicitud enviada correctamente.";
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error al registrar el interés: " . $e->getMessage();
        }
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
<body>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<div class="container mt-5">
    <h1 class="text-center mb-4">Registro de Aspirantes</h1>
    <table class="table mt-5">
        <thead>
            <tr>
                <th>Nombre del Servicio</th>
                <th>Objectivo del Servicio</th>
                <th>Modalidad</th>
                <th>Descripción del Servicio</th>
                <th>Costo del Servicio</th>
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
                        <td><a href='#' data-bs-toggle='modal' data-bs-target='#cursoModal{$row['id_Curso']}'>{$row['NombreCurso']}</a></td>
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

                // Modal con la información del curso
                echo "
                <div class='modal fade' id='cursoModal{$row['id_Curso']}' tabindex='-1' aria-labelledby='cursoModalLabel{$row['id_Curso']}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='cursoModalLabel{$row['id_Curso']}'>{$row['NombreCurso']}</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <p><strong>Objetivo:</strong> {$row['ObjectivoCurso']}</p>
                                <p><strong>Modalidad:</strong> {$row['Modalidad']}</p>
                                <p><strong>Descripción:</strong> {$row['DescripcionCurso']}</p>
                             <p><strong>Descripción:</strong> {$row['ConocimientosCurso']}</p>
                               <p><strong>Descripción:</strong> {$row['ContenidoCurso']}</p>
                                <p><strong>Costo:</strong> {$row['CostoCurso']}</p>
                        <a href='{$pdf}' download='{$pdfFilename}' class='btn btn-info'>Descargar PDF</a>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>";
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

<!-- Modal -->
<?php if ($mostrarModal): ?>
    <div class="modal show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel"><?php echo $mensajeModal == "Ya estás registrado en el grupo." ? "Registro Duplicado" : "Registro Exitoso"; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $mensajeModal; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if ($mostrarModal): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        <?php endif; ?>
    });
</script>

</body>
</html>
