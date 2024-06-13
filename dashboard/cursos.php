<?php
require 'conexion.php';
require 'lanzar.php';
require 'verificar_estado.php';
require 'indexa.php';


?>
<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $courseId = $_POST['id_Curso'];

        switch ($_POST['action']) {
            case 'edit':
                // Editar curso
                // Aquí puedes poner el código para editar un curso
                break;
            case 'delete':
                // Eliminar curso
                $sql = "DELETE FROM curso WHERE id_Curso = $courseId";
                $conn->query($sql);
                break;
            case 'pause':
                // Pausar curso
                $sql = "UPDATE grupo SET Status = 2 WHERE Fk_id_Curso = $courseId";
                $conn->query($sql);
                break;
            case 'cancel':
                // Cancelar curso
                $sql = "UPDATE grupo SET Status = 0 WHERE Fk_id_Curso = $courseId";
                $conn->query($sql);
                break;
            case 'complete':
                // Concluir curso
                $sql = "UPDATE grupo SET Status = 1 WHERE Fk_id_Curso = $courseId";
                $conn->query($sql);
                break;
            case 'launch':
                // Lanzar curso
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFin = $_POST['fechaFin'];
                $sql = "UPDATE grupo SET FechaI = '$fechaInicio', FechaF = '$fechaFin', Status = 1 WHERE Fk_id_Curso = $courseId";
                $conn->query($sql);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Cursos</title>
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
  <h2>Gestión de Cursos</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nombre del Curso</th>
        <th>Modalidad</th>
        <th>Descripción</th>
        <th>Docente</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Finalización</th>
        <th>Cupo Máximo</th>
        <th>Costo</th>
        <th>Activar</th>
        <th>Estatus</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT curso.id_Curso, curso.NombreCurso, curso.Modalidad, curso.DescripcionCurso, convocatoria.DocenteConvoca, grupo.FechaI, grupo.FechaF, grupo.Capacidad, grupo.Costo, grupo.Status 
              FROM curso 
              LEFT JOIN grupo ON curso.id_Curso = grupo.Fk_id_Curso 
              LEFT JOIN convocatoria ON curso.Fk_id_ofer = convocatoria.Id_Convoca";
      $result = $conn->query($sql);

      while($row = $result->fetch_assoc()) {
        $status = "Falta Información";
        if ($row['FechaI'] && $row['FechaF']) {
          $status = "Concluir";
        } else if ($row['Status'] === 0) {
          $status = "Cancelado";
        }

        $courseId = $row['id_Curso'];
        $registeredStudentsSql = "SELECT COUNT(*) AS total FROM grupo WHERE Fk_id_Curso = $courseId";
        $registeredStudentsResult = $conn->query($registeredStudentsSql);
        $registeredStudents = $registeredStudentsResult->fetch_assoc()['total'];

        echo "<tr>
                <td><a href='#' data-bs-toggle='modal' data-bs-target='#alumnosModal{$courseId}' 
                    title='Ver Alumnos Registrados'>{$row['NombreCurso']}</a></td>
                <td>{$row['Modalidad']}</td>
                <td>{$row['DescripcionCurso']}</td>
                <td>{$row['DocenteConvoca']}</td>
                <td>{$row['FechaI']}</td>
                <td>{$row['FechaF']}</td>
                <td>{$registeredStudents}/{$row['Capacidad']}</td>
                <td>{$row['Costo']}</td>
                <td><button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#actividadModal{$courseId}'><i class='fa fa-play'></i></button></td>
                <td><span class='badge bg-" . ($status === "Concluir" ? "success" : ($status === "Cancelado" ? "danger" : "warning")) . "'>{$status}</span></td>
                <td>
                  <div class='btn-group'>
                    <form method='post'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='edit'>
                      <button type='submit' class='btn btn-primary'><i class='fa fa-edit'></i></button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='delete'>
                      <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i></button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='pause'>
                      <button type='submit' class='btn btn-warning'><i class='fa fa-pause'></i></button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='cancel'>
                      <button type='submit' class='btn btn-secondary'><i class='fa fa-times'></i></button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='id_Curso' value='{$courseId}'>
                      <input type='hidden' name='action' value='complete'>
                      <button type='submit' class='btn btn-success'><i class='fa fa-check'></i></button>
                    </form>
                  </div>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
$result->data_seek(0);
while($row = $result->fetch_assoc()) {
  $courseId = $row['id_Curso'];
  $studentsSql = "SELECT user.vNombre FROM grupo 
                  JOIN alumnos ON grupo.Fk_id_Alumno = alumnos.id_Alumno
                  JOIN user ON alumnos.Fk_id_User = user.id_User
                  WHERE grupo.Fk_id_Curso = $courseId";
  $studentsResult = $conn->query($studentsSql);
  $students = [];
  while($student = $studentsResult->fetch_assoc()) {
    $students[] = $student['vNombre'];
  }
  $studentsList = implode(", ", $students);

  echo "<div class='modal fade' id='alumnosModal{$courseId}' tabindex='-1' aria-labelledby='alumnosModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='alumnosModalLabel'>Alumnos Registrados en {$row['NombreCurso']}</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                <p>{$studentsList}</p>
              </div>
            </div>
          </div>
        </div>";
}
?>

<?php
$result->data_seek(0);
while($row = $result->fetch_assoc()) {
  $courseId = $row['id_Curso'];

  echo "<div class='modal fade' id='actividadModal{$courseId}' tabindex='-1' aria-labelledby='actividadModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='actividadModalLabel'>Lanzar Curso: {$row['NombreCurso']}</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
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
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
