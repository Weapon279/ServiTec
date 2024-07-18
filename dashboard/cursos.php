<?php
require 'conexion.php';
require 'indexa.php';

// Definir la cantidad de resultados por página y obtener la página actual
$resultsPerPage = 10; // Número de resultados por página
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Página actual

// Lógica para manejar las acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $courseId = $_POST['id_Curso'];

        $status = '';

        switch ($_POST['action']) {
            case 'edit':
                // Editar curso
                $nombreCurso = isset($_POST['nombreCurso']) ? $_POST['nombreCurso'] : '';
                $modalidad = isset($_POST['modalidad']) ? $_POST['modalidad'] : '';
                $descripcionCurso = isset($_POST['descripcionCurso']) ? $_POST['descripcionCurso'] : '';
                $conocimientoCurso = isset($_POST['ConocimientosCurso']) ? $_POST['ConocimientosCurso'] : '';
                $contenidoCurso = isset($_POST['contenidoCurso']) ? $_POST['contenidoCurso'] : '';
                $objectivoCurso = isset($_POST['objectivoCurso']) ? $_POST['objectivoCurso'] : '';
                $docenteConvoca = isset($_POST['DocenteConvoca']) ? $_POST['DocenteConvoca'] : '';
                $capacidad = isset($_POST['capacidad']) ? $_POST['capacidad'] : '';
                $costo = isset($_POST['costo']) ? $_POST['costo'] : '';
                
                $costo = $_POST['costo'];
                $sql = "UPDATE curso 
                        SET NombreCurso = '$nombreCurso', Modalidad = '$modalidad', DescripcionCurso = '$descripcionCurso', CostoCurso = '$costo' , ObjectivoCurso = '$objectivoCurso', ConocimientosCurso = '$conocimientoCurso'
                        WHERE id_Curso = $courseId";
                $conn->query($sql);
                $sql = "UPDATE convocatoria 
                        SET DocenteConvoca = '$docenteConvoca'
                        WHERE Id_Convoca = (SELECT Fk_id_ofer FROM curso WHERE id_Curso = $courseId)";
                $conn->query($sql);
                $sql = "UPDATE grupo 
                        SET Capacidad = '$capacidad', Status = 1 
                        WHERE Fk_id_Curso = $courseId";
                $conn->query($sql);
                break;

            case 'delete':
                // Eliminar curso
                $sql = "UPDATE curso SET Status = 'Cancelado', FechaHoraC = NULL, FechaHoraA = NULL WHERE id_Curso = $courseId";
                $conn->query($sql);
                $sql = "UPDATE convocatoria SET DocenteConvoca = '' WHERE Id_Convoca = (SELECT Fk_id_ofer FROM curso WHERE id_Curso = $courseId)";
                $conn->query($sql);
                break;

            case 'pause':
                // Suspender curso
                $sql = "UPDATE curso SET Status = 'Suspender' WHERE id_Curso = $courseId";
                $conn->query($sql);
                break;

            case 'cancel':
                // Cancelar curso
                $sql = "UPDATE curso SET FechaHoraC = NULL, FechaHoraA = NULL, Status = 'Falta Informacion' WHERE id_Curso = $courseId";
                $conn->query($sql);
                break;

            case 'complete':
                // Concluir curso
                $sql = "UPDATE curso SET FechaHoraC = NULL, FechaHoraA = NULL, Status = 'Concluir' WHERE id_Curso = $courseId";
                $conn->query($sql);
                $sql = "UPDATE convocatoria SET DocenteConvoca = '' WHERE Id_Convoca = (SELECT Fk_id_ofer FROM curso WHERE id_Curso = $courseId)";
                $conn->query($sql);
                break;

                case 'launch':
                  // Lanzar curso
                  $fechaInicio = $_POST['fechaInicio'];
                  $fechaFin = $_POST['fechaFin'];
                  $fechaHoraActual = date('Y-m-d H:i:s');
                  $nombreGrupo = $_POST['nombreGrupo'];  // Asegúrate de obtener este valor del formulario
              
                  $sqlCurso = "UPDATE curso SET Status = 'Disponible' WHERE id_Curso = $courseId";

                  // Insertar nuevo grupo
                  $sqlGrupo = "INSERT INTO grupo (Fk_id_Curso, ClaveGrupo, FechaI, FechaF, Capacidad, Status, FechaHoraC, FechaHoraA) 
                               VALUES ($courseId, '$nombreGrupo', '$fechaInicio', '$fechaFin', 25, 1, '$fechaHoraActual', '$fechaHoraActual')";
              
                  if ($conn->query($sqlCurso) === TRUE && $conn->query($sqlGrupo) === TRUE) {
                      echo "Curso lanzado correctamente.";
                  } else {
                      echo "Error: " . $conn->error;
                  }
                  break;
                  case 'toggle_status':
                    // Cambiar estado del curso
                    $newStatus = $_POST['status'] == 'Disponible' ? 'Cancelado' : 'Disponible';
                    $sql = "UPDATE curso SET Status = '$newStatus' WHERE id_Curso = $courseId";
                    $conn->query($sql);
                    break;
            
                      }
              
                    
                  
                  
              
              
      


    }
}

// Consulta SQL para obtener la cantidad total de cursos
$totalCoursesSql = "SELECT COUNT(*) AS total FROM curso";
$totalCoursesResult = $conn->query($totalCoursesSql);
$totalCourses = $totalCoursesResult->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPages = ceil($totalCourses / $resultsPerPage);

// Calcular el índice inicial
$offset = ($page - 1) * $resultsPerPage;

// Consulta SQL paginada con orden alfabético por nombre de curso
$sql = "SELECT curso.id_Curso, curso.NombreCurso, curso.Modalidad, curso.DescripcionCurso, curso.ObjectivoCurso, curso.ConocimientosCurso, curso.ContenidoCurso, curso.FechaHoraC, curso.FechaHoraA, grupo.Capacidad, curso.CostoCurso, curso.Status , convocatoria.DocenteConvoca
        FROM curso 
        LEFT JOIN grupo ON curso.id_Curso = grupo.Fk_id_Alumno
        LEFT JOIN convocatoria ON curso.Fk_id_ofer = convocatoria.Id_Convoca
        ORDER BY curso.NombreCurso ASC
        LIMIT $offset, $resultsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Servicios</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Servicios</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th><a href="?sort=name_asc">Nombre del Curso</a></th>
        <th>Modalidad</th>
        <th>Descripción</th>
        <th>Objectivo</th>
        <th>Conocimientos</th>
        <th>Docente</th>
        <th>Costo</th>
        <th>Activar</th>
        <th>Estatus</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($row = $result->fetch_assoc()) {
          $status = $row['Status'];
          $courseId = $row['id_Curso'];
          
          $registeredStudentsSql = "SELECT COUNT(*) AS total FROM inscripciones WHERE Fk_id_Grupo = $courseId";
          $registeredStudentsResult = $conn->query($registeredStudentsSql);
          $registeredStudents = $registeredStudentsResult->fetch_assoc()['total'];

          echo "<tr>
                  <td><a href='#' data-bs-toggle='modal' data-bs-target='#alumnosModal{$courseId}' 
                      title='Ver Grupos Registrados'>{$row['NombreCurso']}</a></td>
                  <td>{$row['Modalidad']}</td>
                  <td>{$row['DescripcionCurso']}</td>
                  <td>{$row['ObjectivoCurso']}</td>
                  <td>{$row['ConocimientosCurso']}</td>
                  <td>{$row['DocenteConvoca']}</td>
                  <td>{$row['CostoCurso']}</td>
                  <td><button class='btn btn-info' data-bs-toggle='modal' title='Dar de alta Grupo' data-bs-target='#actividadModal{$courseId}'><i class='fa fa-play'></i></button></td>
                  <td><span class='badge bg-" . ($status === "Disponible" ? "success" : ($status === "Cancelado" ? "danger" : ($status === "Suspender" ? "warning" : "info"))) . "'>{$status}</span></td>
                  <td>
                    <div class='btn-group'>
                      <button class='btn btn-primary' data-bs-toggle='modal' title='Editar Servicio' data-bs-target='#editModal{$courseId}'><i class='fa fa-edit'></i></button>
                      <form method='post' style='display:inline-block'>
                        <input type='hidden' name='id_Curso' value='{$courseId}'>
                        <input type='hidden' name='action' value='cancel'>
                        <button type='submit' title='Cancelar Servicio' class='btn btn-danger'><i class='fa fa-trash'></i></button>
                      <form method='post' action=''>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='toggle_status'>
                      <input type='hidden' name='status' value='{$status}'>
                        <div class='form-check form-switch'>
                        <input class='form-check-input' title='Activar / Desactivar' type='checkbox' id='statusSwitch{$courseId}' " . ($status == 'Disponible' ? 'checked' : '') . " onchange='this.form.submit()'>
                      </div>
                        </form>
                    <form method='post' style='display:inline-block'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='pause'>
                      <button type='submit' class='btn btn-warning' title='Pausar Servicio'><i class='fa fa-pause'></i></button>
                    </form>
                    <form method='post' style='display:inline-block'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='delete'>
                      <button type='submit' class='btn btn-secondary' title='Eliminar Servicio'><i class='fa fa-times'></i></button>
                    </form>
                    <form method='post' style='display:inline-block'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='complete'>
                      <button type='submit' class='btn btn-success' title='Completar Servicio'><i class='fa fa-check'></i></button>
                    </form>
                    </div>
                  </td>
                </tr>";

          // Modal para editar curso
          echo "<div class='modal fade' id='editModal{$courseId}' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'  id='editModalLabel'>Editar Curso: {$row['NombreCurso']}</h5>
                <button type='submit'  class='btn-close'   data-bs-dismiss='modal'  aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                <form action='' method='post'>
                  <input type='hidden' name='id_Curso' value='{$courseId}'>
                  <input type='hidden' name='action' value='edit'>
                  <div class='mb-3'>
                    <label for='nombreCurso' class='form-label'>Nombre del Curso</label>
                    <input type='text' class='form-control' id='nombreCurso' name='nombreCurso' value='{$row['NombreCurso']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='modalidad' class='form-label'>Modalidad</label>
                    <input type='text' class='form-control' id='modalidad' name='modalidad' value='{$row['Modalidad']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='descripcionCurso' class='form-label'>Descripción</label>
                    <textarea class='form-control' id='descripcionCurso' name='descripcionCurso' rows='3' required>{$row['DescripcionCurso']}</textarea>
                  </div>
                  <div class='mb-3'>
                    <label for='objectivoCurso' class='form-label'>Objetivo</label>
                    <input type='text' class='form-control' id='objectivoCurso' name='objectivoCurso' value='{$row['ObjectivoCurso']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='conocimientoCurso' class='form-label'>Conocimiento Curso</label>
                    <input type='text' class='form-control' id='conocimientoCurso' name='conocimientoCurso' value='{$row['ConocimientosCurso']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='contenidoCurso' class='form-label'>Contenido Curso</label>
                    <input type='text' class='form-control' id='contenidoCurso' name='contenidoCurso' value='{$row['ContenidoCurso']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='capacidad' class='form-label'>Capacidad</label>
                    <input type='number' class='form-control' id='capacidad' name='capacidad' value='{$row['Capacidad']}' required>
                  </div>
                  <div class='mb-3'>
                    <label for='costo' class='form-label'>Costo</label>
                    <input type='number' class='form-control' id='costo' name='costo' value='{$row['CostoCurso']}' required>
                  </div>
                  <button type='submit' class='btn btn-primary'>Guardar cambios</button>
                </form>
              </div>
            </div>
          </div>
        </div>";
  
      }
      ?>
    </tbody>
  </table>

  <!-- Paginación -->
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <?php
      // Mostrar enlaces de paginación
      for ($i = 1; $i <= $totalPages; $i++) {
          echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
      }
      ?>
    </ul>
  </nav>

</div>

<!-- Modales para alumnos y lanzar curso -->
<?php


  // Modal para ver Grupos

  // Obtener cursos
  $sqlCursos = "SELECT id_Curso, NombreCurso FROM curso";
  $resultCursos = $conn->query($sqlCursos);
  
  while ($row = $resultCursos->fetch_assoc()) {
      $courseId = $row['id_Curso'];
      $sqlGrupos = "SELECT ClaveGrupo, FechaI, FechaF FROM grupo WHERE Fk_id_Curso = ?";
      $stmtGrupos = $conn->prepare($sqlGrupos);
      $stmtGrupos->bind_param("i", $courseId);
      $stmtGrupos->execute();
      $resultGrupos = $stmtGrupos->get_result();
      ?>
  
      <!-- Modal para mostrar los grupos disponibles para el curso -->
      <div class='modal fade' id='alumnosModal<?php echo $courseId; ?>' tabindex='-1' aria-labelledby='alumnosModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h5 class='modal-title' id='alumnosModalLabel'>Grupos Registrados en <?php echo $row['NombreCurso']; ?></h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                      <?php if ($resultGrupos->num_rows > 0): ?>
                          <ul class='list-group'>
                              <?php while ($grupo = $resultGrupos->fetch_assoc()): ?>
                                  <li class='list-group-item'>
                                      <strong>Clave del Grupo:</strong> <?php echo $grupo['ClaveGrupo']; ?><br>
                                      <strong>Fecha de Inicio:</strong> <?php echo $grupo['FechaI']; ?><br>
                                      <strong>Fecha de Finalización:</strong> <?php echo $grupo['FechaF']; ?>
                                  </li>
                              <?php endwhile; ?>
                          </ul>
                      <?php else: ?>
                          <p>El Curso no cuenta con grupos registrados...</p>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
      </div>
  
      <?php
      $stmtGrupos->close();
  }
  

        

  
  require 'conexion.php';
  
  // Obtener cursos
  $sqlCursos = "SELECT id_Curso, NombreCurso FROM curso";
  $resultCursos = $conn->query($sqlCursos);
  
  if ($resultCursos->num_rows > 0) {
      while ($row = $resultCursos->fetch_assoc()) {
          $courseId = $row['id_Curso'];
          $courseName = $row['NombreCurso'];
  
          // Verifica que courseId y courseName no sean nulos
          if (isset($courseId) && isset($courseName)) {
              // Modal para lanzar curso
              echo "<div class='modal fade' id='actividadModal{$courseId}' tabindex='-1' aria-labelledby='alumnosModalLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                          <div class='modal-content'>
                              <div class='modal-header'>
                                  <h5 class='modal-title' id='alumnosModalLabel'>Lanzar Curso: {$courseName}</h5>
                                  <button type='button'  class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                              </div>
                              <div class='modal-body'>
                                  <form action='' method='post'>
                                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                                      <input type='hidden' name='action' value='launch'>
                                      <div class='mb-3'>
                                          <label for='fechaInicio' class='form-label'>Fecha de Inicio</label>
                                          <input type='datetime-local' class='form-control' id='fechaInicio' name='fechaInicio' required>
                                      </div>
                                      <div class='mb-3'>
                                          <label for='fechaFin' class='form-label'>Fecha de Fin</label>
                                          <input type='datetime-local' class='form-control' id='fechaFin' name='fechaFin' required>
                                      </div>
                                      <button type='submit' class='btn btn-primary'>Lanzar</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>";
          }
      }
  } else {
      echo "No se encontraron cursos.";
  }
  
  ?>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
