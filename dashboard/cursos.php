<?php include 'conexion.php'; ?>
<?php include 'indexa.php'; ?>


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
        $status = "Amarillo";
        if ($row['FechaI'] && $row['FechaF']) {
          $status = "Verde";
        } else if ($row['Status'] === 0) {
          $status = "Rojo";
        }
        echo "<tr>
                <td><a href='#' data-bs-toggle='modal' data-bs-target='#alumnosModal{$row['id_Curso']}' 
                    title='Ver Alumnos Registrados'>{$row['NombreCurso']}</a></td>
                <td>{$row['Modalidad']}</td>
                <td>{$row['DescripcionCurso']}</td>
                <td>{$row['DocenteConvoca']}</td>
                <td>{$row['FechaI']}</td>
                <td>{$row['FechaF']}</td>
                <td>{$row['Capacidad']}</td>
                <td>{$row['Costo']}</td>
                <td><button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#actividadModal{$row['id_Curso']}'>Lanzar</button></td>
                <td><span class='badge bg-{$status}'>{$status}</span></td>
                <td>
                  <div class='btn-group'>
                    <button class='btn btn-primary'>Editar</button>
                    <button class='btn btn-danger'>Eliminar</button>
                    <button class='btn btn-warning'>Suspender</button>
                    <button class='btn btn-secondary'>Cancelar</button>
                    <button class='btn btn-success'>Concluir</button>
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
  echo "<div class='modal fade' id='alumnosModal{$row['id_Curso']}' tabindex='-1' aria-labelledby='alumnosModalLabel' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='alumnosModalLabel'>Alumnos Registrados en {$row['NombreCurso']}</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                <p>Aquí va la lista de alumnos registrados...</p>
              </div>
            </div>
          </div>
        </div>";
}
?>

<?php
// ... Existing code for actividadModal ...
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
