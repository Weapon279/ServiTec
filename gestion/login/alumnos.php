<?php include 'conexion.php'; ?>
<?php include 'dash.php'; ?>

<div class="container mt-5">
    <h2>Gestión de Alumnos</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Usuario</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>WhatsApp</th>
                <th>Curso Actual</th>
                <th>Diplomas Obtenidos</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT user.vNombre, user.vApellidoP, user.vCorreo, user.nWhats, curso.NombreCurso, alumnos.Status 
                    FROM user 
                    LEFT JOIN alumnos ON user.id_User = alumnos.Fk_id_User 
                    LEFT JOIN grupo ON alumnos.id_Alumno = grupo.Fk_id_Alumno 
                    LEFT JOIN curso ON grupo.Fk_id_Curso = curso.id_Curso";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                $status = "Disponible";
                if ($row['Status'] == 0) {
                    $status = "Inactivo";
                } else if ($row['Status'] == 1) {
                    $status = "Documentos Pendientes";
                }
                echo "<tr>
                        <td>{$row['vNombre']}</td>
                        <td>{$row['vApellidoP']}</td>
                        <td>{$row['vCorreo']}</td>
                        <td>{$row['nWhats']}</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>-</td>
                        <td><span class='badge bg-{$status}'>{$status}</span></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
