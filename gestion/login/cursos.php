<?php include 'conexion.php'; ?>
<?php include 'index.php'; ?>

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
                <th>Actividad</th>
                <th>Estatus</th>
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
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['Modalidad']}</td>
                        <td>{$row['DescripcionCurso']}</td>
                        <td>{$row['DocenteConvoca']}</td>
                        <td>{$row['FechaI']}</td>
                        <td>{$row['FechaF']}</td>
                        <td>{$row['Capacidad']}</td>
                        <td>{$row['Costo']}</td>
                        <td><button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#actividadModal{$row['id_Curso']}'>Actividad</button></td>
                        <td><span class='badge bg-{$status}'>{$status}</span></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para actividad -->
<?php
$result->data_seek(0);
while($row = $result->fetch_assoc()) {
    echo "<div class='modal fade' id='actividadModal{$row['id_Curso']}' tabindex='-1' aria-labelledby='actividadModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='actividadModalLabel'>Agregar Actividad para {$row['NombreCurso']}</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form>
                            <div class='mb-3'>
                                <label for='fechaInicio' class='form-label'>Fecha y Hora de Inicio</label>
                                <input type='datetime-local' class='form-control' id='fechaInicio'>
                            </div>
                            <div class='mb-3'>
                                <label for='fechaFin' class='form-label'>Fecha y Hora de Finalización</label>
                                <input type='datetime-local' class='form-control' id='fechaFin'>
                            </div>
                            <button type='submit' class='btn btn-primary'>Guardar</button>
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
