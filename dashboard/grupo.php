<?php
include 'indexa.php';
include 'conexion.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumno_id = $_POST['alumno_id'];
    $grupo_id = $_POST['grupo_id'];
    $accion = $_POST['accion'];

    if ($accion == 'aceptar') {
        // Actualizar el estado del aspirante a aceptado
        $sql = "UPDATE alumnos SET Status = 1 WHERE id_Alumno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $alumno_id);
        $stmt->execute();
    } elseif ($accion == 'rechazar') {
        // Actualizar el estado del aspirante a rechazado
        $sql = "UPDATE alumnos SET Status = 2 WHERE id_Alumno = ?"; // 2 para rechazado
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $alumno_id);
        $stmt->execute();
    }

    // Redirigir para evitar reenvío del formulario
    header("Location: registroc.php");
    exit();
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
    <div class="container mt-5">
        <h1 class="text-center mb-4">Grupos</h1>
        <?php
        $sql = "SELECT g.id_Grupo, g.ClaveGrupo, g.Capacidad, g.FechaHoraC, g.FechaHoraA, c.NombreCurso 
                FROM grupo g
                JOIN curso c ON g.Fk_id_Curso = c.id_Curso";
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
                            <th>Ver Alumnos</th>
                            <th>Ver Aspirantes</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                $groupId = $row['id_Grupo'];
                echo "<tr>
                        <td>{$row['ClaveGrupo']}</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['Capacidad']}</td>
                        <td>{$row['FechaHoraC']}</td>
                        <td>{$row['FechaHoraA']}</td>
                        <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#alumnosModal{$groupId}'>Ver Alumnos</button></td>
                        <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#aspirantesModal{$groupId}'>Ver Aspirantes</button></td>
                      </tr>";

                // Modal para mostrar los alumnos del grupo
                echo "<div class='modal fade' id='alumnosModal{$groupId}' tabindex='-1' aria-labelledby='alumnosModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='alumnosModalLabel{$groupId}'>Alumnos del Grupo {$row['ClaveGrupo']}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>";
                
                $studentsSql = "SELECT u.vNombre 
                                FROM alumnos a
                                JOIN user u ON a.Fk_id_User = u.id_User
                                WHERE a.Fk_grupo = ?";
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
                              <h5 class='modal-title' id='aspirantesModalLabel{$groupId}'>Solicitudes para el Grupo {$row['ClaveGrupo']}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>";

                $applicationsSql = "SELECT u.vNombre, a.id_Alumno
                                    FROM alumnos a
                                    JOIN user u ON a.Fk_id_User = u.id_User
                                    WHERE a.Fk_grupo = ? AND a.Status = 0";
                $stmt = $conn->prepare($applicationsSql);
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $applicationsResult = $stmt->get_result();

                if ($applicationsResult->num_rows > 0) {
                    echo "<ul>";
                    while ($application = $applicationsResult->fetch_assoc()) {
                        echo "<li>{$application['vNombre']}
                              <form method='POST' action='registroc.php' style='display:inline;'>
                                <input type='hidden' name='alumno_id' value='{$application['id_Alumno']}'>
                                <input type='hidden' name='grupo_id' value='{$groupId}'>
                                <input type='hidden' name='accion' value='aceptar'>
                                <button type='submit' class='btn btn-success'>Aceptar</button>
                              </form>
                              <form method='POST' action='registroc.php' style='display:inline;'>
                                <input type='hidden' name='alumno_id' value='{$application['id_Alumno']}'>
                                <input type='hidden' name='grupo_id' value='{$groupId}'>
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
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron grupos.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
