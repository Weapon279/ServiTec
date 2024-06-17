<?php
session_start();
require 'conexion.php';

// Obtener el ID del usuario actual
$currentUserId = $_SESSION['user_id'];

// Obtener el rol del usuario
$userRoleSql = "SELECT Role FROM user WHERE id_User = $currentUserId";
$userRoleResult = $conn->query($userRoleSql);
$userRoleRow = $userRoleResult->fetch_assoc();
$userRole = $userRoleRow['Role'];

// Cambiar el tipo de usuario a "alumno" si se registra en un curso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $courseId = $_POST['courseId'];

        // Verificar si el usuario ya es alumno
        $alumnoSql = "SELECT id_Alumno FROM alumnos WHERE Fk_id_User = $currentUserId";
        $alumnoResult = $conn->query($alumnoSql);

        if ($alumnoResult->num_rows == 0) {
            // Insertar al usuario en la tabla alumnos como "aspirante"
            $insertAlumnoSql = "INSERT INTO alumnos (Fk_id_User, Status) VALUES ($currentUserId, 0)";
            $conn->query($insertAlumnoSql);
            $alumnoId = $conn->insert_id;
        } else {
            $alumnoRow = $alumnoResult->fetch_assoc();
            $alumnoId = $alumnoRow['id_Alumno'];
        }

        // Insertar en la tabla grupo
        $insertGroupSql = "INSERT INTO grupo (Fk_id_Curso, Fk_id_Alumno, Capacidad, Status) 
                           VALUES ($courseId, $alumnoId, 
                           (SELECT Capacidad FROM curso WHERE id_Curso = $courseId), 1)";
        $conn->query($insertGroupSql);

        // Cambiar el rol del usuario a "alumno" (0 = aspirante, 1 = alumno)
        $updateUserRoleSql = "UPDATE user SET Role = 'alumno' WHERE id_User = $currentUserId";
        $conn->query($updateUserRoleSql);

        // Verificar si se debe crear un nuevo grupo
        $cursoSql = "SELECT Capacidad FROM curso WHERE id_Curso = $courseId";
        $cursoResult = $conn->query($cursoSql);
        $cursoRow = $cursoResult->fetch_assoc();
        $capacidadMaxima = $cursoRow['Capacidad'];

        $alumnosRegistradosSql = "SELECT COUNT(*) AS total FROM grupo WHERE Fk_id_Curso = $courseId";
        $alumnosRegistradosResult = $conn->query($alumnosRegistradosSql);
        $alumnosRegistrados = $alumnosRegistradosResult->fetch_assoc()['total'];

        if ($alumnosRegistrados >= $capacidadMaxima) {
            // Crear una nueva convocatoria y oferta
            $insertConvocatoriaSql = "INSERT INTO convocatoria (Fk_id_Grupo, Status) VALUES ((SELECT id_Grupo FROM grupo WHERE Fk_id_Curso = $courseId LIMIT 1), 1)";
            $conn->query($insertConvocatoriaSql);

            $insertOfertaSql = "INSERT INTO oferta (Fk_id_convoca, Status) VALUES ((SELECT Id_Convoca FROM convocatoria ORDER BY Id_Convoca DESC LIMIT 1), 1)";
            $conn->query($insertOfertaSql);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Servicios</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<div class="container mt-5">
  <h2>Cursos Disponibles</h2>
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
        <th>Registrarse</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT curso.id_Curso, curso.NombreCurso, curso.Modalidad, curso.DescripcionCurso, convocatoria.DocenteConvoca, curso.FechaHoraC, curso.FechaHoraA, curso.CupoMaximo, curso.CostoCurso 
              FROM curso 
              LEFT JOIN convocatoria ON curso.id_Curso = convocatoria.Fk_id_Grupo 
              WHERE curso.Status = 1"; // Status 1 para cursos disponibles
      $result = $conn->query($sql);

      while($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['NombreCurso']}</td>
                  <td>{$row['Modalidad']}</td>
                  <td>{$row['DescripcionCurso']}</td>
                  <td>{$row['DocenteConvoca']}</td>
                  <td>{$row['FechaHoraC']}</td>
                  <td>{$row['FechaHoraA']}</td>
                  <td>{$row['CupoMaximo']}</td>
                  <td>{$row['CostoCurso']}</td>
                  <td>
                    <form method='POST' action=''>
                      <input type='hidden' name='courseId' value='{$row['id_Curso']}'>
                      <button type='submit' name='register' class='btn btn-success'>
                        <i class='fa fa-check'></i>
                      </button>
                    </form>
                  </td>
                </tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
