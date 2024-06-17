<?php
include 'indexa.php';
include 'conexion.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Grupos</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Grupos</h1>
        <?php

        // Obtener la información de los grupos y cursos
        $sql = "SELECT g.id_Grupo, g.ClaveGrupo, g.Capacidad, g.FechaI, g.FechaF, c.NombreCurso 
                FROM grupo g
                JOIN curso c ON g.Fk_id_Curso = c.id_Curso";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped'>
                    <thead class='table table-striped'>
                        <tr>
                            <th>Clave del Grupo</th>
                            <th>Nombre del Curso</th>
                            <th>Capacidad</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Ver Alumnos</th>
                            <th>Solicitud</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $result->fetch_assoc()) {
                $groupId = $row['id_Grupo'];
                echo "<tr>
                        <td>{$row['ClaveGrupo']}</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['Capacidad']}</td>
                        <td>{$row['FechaI']}</td>
                        <td>{$row['FechaF']}</td>
                        <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#alumnosModal{$groupId}'>Ver Alumnos</button></td>
                        <td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#solicitudModal{$groupId}'>Solicitud</button></td>
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
                
                // Obtener los alumnos del grupo
                $studentsSql = "SELECT u.vNombre 
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
                echo "<div class='modal fade' id='solicitudModal{$groupId}' tabindex='-1' aria-labelledby='solicitudModalLabel{$groupId}' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='solicitudModalLabel{$groupId}'>Solicitudes para el Grupo {$row['ClaveGrupo']}</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>";
                
                // Obtener las solicitudes de los aspirantes para el grupo
                $applicationsSql = "SELECT u.vNombre, a.Status 
                                    FROM alumnos a
                                    JOIN user u ON a.Fk_id_User = u.id_User
                                    WHERE a.Fk_Id_Grupo = ? AND a.Status = 0";
                $stmt = $conn->prepare($applicationsSql);
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $applicationsResult = $stmt->get_result();

                if ($applicationsResult->num_rows > 0) {
                    echo "<ul>";
                    while ($application = $applicationsResult->fetch_assoc()) {
                        echo "<li>{$application['vNombre']}
                              <button type='button' class='btn btn-success'>Aceptar</button>
                              <button type='button' class='btn btn-danger'>Rechazar</button>
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