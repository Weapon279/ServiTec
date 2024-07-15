<?php
include 'indexa.php';
include 'conexion.php';
session_start();

$error_message = '';

// Configuración de paginación
$limit = 10; // Número de registros por página
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Motor de búsqueda
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $interes_id = isset($_POST['interes_id']) ? $_POST['interes_id'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    try {
        if ($accion == 'aceptar') {
            $conn->begin_transaction();

            $sql = "SELECT Fk_id_User, Fk_id_Grupo FROM intereses WHERE id_Intereses = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $interes_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $interes = $result->fetch_assoc();

            $sql_check = "SELECT * FROM alumnos WHERE Fk_id_User = ? AND Fk_Id_Grupo = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("ii", $interes['Fk_id_User'], $interes['Fk_id_Grupo']);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                throw new Exception('El usuario ya está registrado en este grupo.');
            } else {
                $sql_insert_alumnos = "INSERT INTO alumnos (Fk_id_User, Fk_Id_Grupo, Status, FechaHoraC) VALUES (?, ?, 1, NOW())";
                $stmt_insert_alumnos = $conn->prepare($sql_insert_alumnos);
                $stmt_insert_alumnos->bind_param("ii", $interes['Fk_id_User'], $interes['Fk_id_Grupo']);
                $stmt_insert_alumnos->execute();

                $sql_insert_inscripciones = "INSERT INTO inscripciones (Fk_id_User, Fk_id_Grupo, FechaHoraC) VALUES (?, ?, NOW())";
                $stmt_insert_inscripciones = $conn->prepare($sql_insert_inscripciones);
                $stmt_insert_inscripciones->bind_param("ii", $interes['Fk_id_User'], $interes['Fk_id_Grupo']);
                $stmt_insert_inscripciones->execute();

                $sql_update_intereses = "UPDATE intereses SET Status = 1 WHERE id_Intereses = ?";
                $stmt_update_intereses = $conn->prepare($sql_update_intereses);
                $stmt_update_intereses->bind_param("i", $interes_id);
                $stmt_update_intereses->execute();

                $conn->commit();
            }
        } elseif ($accion == 'rechazar') {
            $sql_update_intereses = "UPDATE intereses SET Status = 0 WHERE id_Intereses = ?";
            $stmt_update_intereses = $conn->prepare($sql_update_intereses);
            $stmt_update_intereses->bind_param("i", $interes_id);
            $stmt_update_intereses->execute();
        } elseif ($accion == 'finalizar') {
            $grupo_id = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

            if (!$grupo_id) {
                throw new Exception('ID de grupo no válido.');
            }

            $sql_move_to_finalizados = "INSERT INTO grupos_finalizados (Fk_id_Curso, Fk_id_Grupo, NombreCurso, FechaInicio, FechaFin, Capacidad, Cupo, ClaveGrupo)
                    SELECT Fk_id_Curso, id_Grupo, c.NombreCurso, FechaI, FechaF, Capacidad, (SELECT COUNT(*) FROM alumnos WHERE Fk_Id_Grupo = g.id_Grupo), ClaveGrupo
                    FROM grupo g
                    JOIN curso c ON g.Fk_id_Curso = c.id_Curso
                    WHERE g.id_Grupo = ?";
            $stmt_move_to_finalizados = $conn->prepare($sql_move_to_finalizados);
            $stmt_move_to_finalizados->bind_param("i", $grupo_id);
            $stmt_move_to_finalizados->execute();

            $sql_update_grupo = "UPDATE grupo SET Status = 0 WHERE id_Grupo = ?";
            $stmt_update_grupo = $conn->prepare($sql_update_grupo);
            $stmt_update_grupo->bind_param("i", $grupo_id);
            $stmt_update_grupo->execute();

            $conn->commit();
        } elseif ($accion == 'cancelar') {
            $grupo_id = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

            if (!$grupo_id) {
                throw new Exception('ID de grupo no válido.');
            }

            $sql_update_grupo = "UPDATE grupo SET Status = 0 WHERE id_Grupo = ?";
            $stmt_update_grupo = $conn->prepare($sql_update_grupo);
            $stmt_update_grupo->bind_param("i", $grupo_id);
            $stmt_update_grupo->execute();
        }

        header("Location: grupo.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $error_message = $e->getMessage();
    }
}

function getGroupLetter($id) {
    $letters = '';
    while ($id > 0) {
        $mod = ($id - 1) % 26;
        $letters = chr(65 + $mod) . $letters;
        $id = (int)(($id - $mod) / 26);
    }
    return $letters;
}

function getGroupNumber($id) {
    return $id;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Grupos</title>
</head>
<body>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Grupos</h1>
        <?php
        if (!empty($error_message)) {
            echo "<div class='modal fade' id='errorModal' tabindex='-1' aria-labelledby='errorModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title' id='errorModalLabel'>Error</h5>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                          <p>{$error_message}</p>
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>";
            echo "<script>
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                  </script>";
        }
        
        // Consulta para obtener los grupos con paginación
        $sql = "SELECT g.id_Grupo, g.ClaveGrupo, g.Capacidad, g.FechaI, g.FechaF, c.NombreCurso 
        FROM grupo g
        JOIN curso c ON g.Fk_id_Curso = c.id_Curso
        WHERE g.Status = 1 ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Clave del Grupo</th>
                            <th>Nombre del Curso</th>
                            <th>Capacidad</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Alumnos</th>
                            <th>Aspirantes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                $groupId = $row['id_Grupo'];
                $groupLetter = getGroupLetter($groupId);
                $groupNumber = getGroupNumber($groupId);

                // Contar el número de alumnos en el grupo
                $sqlCount = "SELECT COUNT(*) as count FROM alumnos WHERE Fk_Id_Grupo = ?";
                $stmtCount = $conn->prepare($sqlCount);
                $stmtCount->bind_param("i", $groupId);
                $stmtCount->execute();
                $resultCount = $stmtCount->get_result();
                $count = $resultCount->fetch_assoc()['count'];

                echo "<tr>
                        <td>{$groupNumber} ({$groupLetter})</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$count}/{$row['Capacidad']}</td>
                        <td>{$row['FechaI']}</td>
                        <td>{$row['FechaF']}</td>
                        <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#alumnosModal{$groupId}'>Ver Alumnos</button></td>
                        <td><button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#aspirantesModal{$groupId}'>Ver Aspirantes</button></td>
                        <td>
                            <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editarModal{$groupId}'>Editar</button>
                            <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#diplomaModal{$groupId}'>Agregar Constancias</button>
                                                        <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#diplomaverModal{$groupId}'>Ver Constancias</button>
                                                    <form action='grupo.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='accion' value='finalizar'>
                                <input type='hidden' name='grupo_id' value='{$groupId}'>
                                <button type='submit' class='btn btn-success'>Finalizar Grupo</button>
                            </form>
                            <form action='grupo.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='accion' value='cancelar'>
                                <input type='hidden' name='grupo_id' value='{$groupId}'>
                                <button type='submit' class='btn btn-danger'>Cancelar Grupo</button>
                            </form>
                                                    </td>

                        
                      </tr>";

                // Modal para mostrar los alumnos del grupo
                echo "<div class='modal fade' id='alumnosModal{$groupId}' tabindex='-1' aria-labelledby='alumnosModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='alumnosModalLabel{$groupId}'>Alumnos del Grupo {$groupLetter}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>";

                $studentsSql = "SELECT u.vNombre, u.vApellidoP 
                                FROM alumnos a
                                JOIN user u ON a.Fk_id_User = u.id_User
                                WHERE a.Fk_Id_Grupo = ?";
                $stmt = $conn->prepare($studentsSql);
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $studentsResult = $stmt->get_result();

                if ($studentsResult->num_rows > 0) {
                    echo "<ul>";
                    while ($student = $studentsResult->fetch_assoc()) {
                        echo "<li>{$student['vNombre']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay alumnos registrados en este grupo.</p>";
                }
                echo "      </div>
                          </div>
                        </div>
                      </div>";

                // Modal para mostrar las solicitudes de los aspirantes
                echo "<div class='modal fade' id='aspirantesModal{$groupId}' tabindex='-1' aria-labelledby='aspirantesModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='aspirantesModalLabel{$groupId}'>Solicitudes para el Grupo {$groupLetter}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>";

                $applicationsSql = "SELECT u.vNombre, u.vApellidoP, i.id_Intereses
                                    FROM intereses i
                                    JOIN user u ON i.Fk_id_User = u.id_User
                                    WHERE i.Fk_id_Grupo = ? AND i.Status = 1";
                $stmt = $conn->prepare($applicationsSql);
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $applicationsResult = $stmt->get_result();

                if ($applicationsResult->num_rows > 0) {
                    echo "<ul>";
                    while ($application = $applicationsResult->fetch_assoc()) {
                        echo "<li>{$application['vNombre']}
                              <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='interes_id' value='{$application['id_Intereses']}'>
                                <input type='hidden' name='accion' value='aceptar'>
                                <button type='submit' class='btn btn-success'>Aceptar</button>
                              </form>
                              <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='interes_id' value='{$application['id_Intereses']}'>
                                <input type='hidden' name='accion' value='rechazar'>
                                <button type='submit' class='btn btn-danger'>Rechazar</button>
                              </form>
                             </li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay solicitudes pendientes para este grupo.</p>";
                }
                echo "      </div>
                          </div>
                        </div>
                      </div>";

                // Modal para editar la información del grupo
                echo "<div class='modal fade' id='editarModal{$groupId}' tabindex='-1' aria-labelledby='editarModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='editarModalLabel{$groupId}'>Editar Grupo {$groupLetter}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                              <form method='POST' action='editar_grupo.php'>
                                <input type='hidden' name='id_grupo' value='{$groupId}'>
                                <div class='mb-3'>
                                  <label for='claveGrupo' class='form-label'>Clave del Grupo</label>
                                  <input type='text' class='form-control' id='claveGrupo' name='claveGrupo' value='{$row['ClaveGrupo']}'>
                                </div>
                                <div class='mb-3'>
                                  <label for='capacidad' class='form-label'>Capacidad</label>
                                  <input type='number' class='form-control' id='capacidad' name='capacidad' value='{$row['Capacidad']}'>
                                </div>
                                <div class='mb-3'>
                                  <label for='fechaI' class='form-label'>Fecha de Inicio</label>
                                  <input type='date' class='form-control' id='fechaI' name='fechaI' value='{$row['FechaI']}'>
                                </div>
                                <div class='mb-3'>
                                  <label for='fechaF' class='form-label'>Fecha de Fin</label>
                                  <input type='date' class='form-control' id='fechaF' name='fechaF' value='{$row['FechaF']}'>
                                </div>
                                <button type='submit' class='btn btn-primary'>Guardar Cambios</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>";

                // Modal para agregar diplomas
                echo "<div class='modal fade' id='diplomaModal{$groupId}' tabindex='-1' aria-labelledby='diplomaModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='diplomaModalLabel{$groupId}'>Agregar Diploma al Grupo {$groupLetter}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                              <form method='POST' action='agregar_diploma.php'>
                                <input type='hidden' name='id_grupo' value='{$groupId}'>
                                <div class='mb-3'>
                                  <label for='nombreDiploma' class='form-label'>Nombre del Diploma</label>
                                  <input type='text' class='form-control' id='nombreDiploma' name='nombreDiploma'>
                                </div>
                                <div class='mb-3'>
                                  <label for='linkDiploma' class='form-label'>Link del Diploma</label>
                                  <input type='text' class='form-control' id='linkDiploma' name='linkDiploma'>
                                </div>
                                <button type='submit' class='btn btn-primary'>Agregar Diploma</button>
                              </form>
                              
                            </div>
                          </div>
                        </div>
                      </div>";

// Modal Ver constancias
$sqlDiplomas = "SELECT NombreDiploma, LinkDiploma, FechaHoraC FROM diplomas WHERE Fk_id_Grupo = ?";
$stmtDiplomas = $conn->prepare($sqlDiplomas);
$stmtDiplomas->bind_param("i", $groupId);
$stmtDiplomas->execute();
$resultDiplomas = $stmtDiplomas->get_result();

echo "<div class='modal fade' id='diplomaverModal{$groupId}' tabindex='-1' aria-labelledby='diplomaverModal{$groupId}' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='diplomaverModal{$groupId}'>Constancias del Grupo {$groupLetter}</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>";

if ($resultDiplomas->num_rows > 0) {
    echo "<ul>";
    while ($diploma = $resultDiplomas->fetch_assoc()) {
        echo "<li>
                <strong>Nombre:</strong> {$diploma['NombreDiploma']}<br>
                <strong>Enlace:</strong> <a href='{$diploma['LinkDiploma']}' target='_blank'>Ver Diploma</a><br>
                <strong>Fecha de Creación:</strong> " . date('d/m/Y H:i', strtotime($diploma['FechaHoraC'])) . "
              </li><hr>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay constancias registradas para este grupo.</p>";
}

echo "          </div>
            </div>
        </div>
      </div>";

            }
            echo "</tbody></table>";

            // Paginación
            $sqlTotal = "SELECT COUNT(*) as total FROM grupo";
            $resultTotal = $conn->query($sqlTotal);
            $total = $resultTotal->fetch_assoc()['total'];
            $totalPages = ceil($total / $limit);

            echo "<nav aria-label='Page navigation'>
                    <ul class='pagination justify-content-center'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<li class='page-item ".($i == $page ? 'active' : '')."'><a class='page-link' href='grupo.php?page={$i}'>{$i}</a></li>";
            }
            echo "  </ul>
                  </nav>";
        } else {
            echo "<p>No se encontraron grupos.</p>";
        }

        // Consulta para obtener los grupos finalizados
        $sqlFinalizados = "SELECT g.ClaveGrupo, g.FechaF, c.NombreCurso, g.Capacidad 
                           FROM grupos_finalizados gf
                           JOIN grupo g ON gf.Fk_id_Grupo = g.id_Grupo
                           JOIN curso c ON gf.Fk_id_Curso = c.id_Curso";
        $resultFinalizados = $conn->query($sqlFinalizados);

        if ($resultFinalizados->num_rows > 0) {
            echo "<h2 class='text-center mt-5'>Grupos Finalizados</h2>";
            echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Fecha de Fin</th>
                            <th>Nombre del Curso</th>
                            <th>Clave del Grupo</th>
                            <th>Capacidad</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $resultFinalizados->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['FechaF']}</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['ClaveGrupo']}</td>
                        <td>{$row['Capacidad']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron grupos finalizados.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
