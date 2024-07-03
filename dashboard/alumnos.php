<?php include 'conexion.php'; ?>
<?php include 'indexa.php'; ?>

<div class="w3-main" style="margin-left: 300px; margin-top: 43px;">

<div class="container mt-5">
    <h2>Gestión de Alumnos</h2>
    <table class="table table-striped table-hover">
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
            // Configuración para paginación
            $results_per_page = 10;
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $start_limit = ($page - 1) * $results_per_page;

            // Consulta SQL con orden alfabético y paginación
            $sql = "SELECT user.vNombre, user.vApellidoP, user.vCorreo, user.nWhats, curso.NombreCurso, alumnos.Status 
                    FROM user 
                    LEFT JOIN alumnos ON user.id_User = alumnos.Fk_id_User 
                    LEFT JOIN grupo ON alumnos.id_Alumno = grupo.Fk_id_Alumno 
                    LEFT JOIN curso ON grupo.Fk_id_Curso = curso.id_Curso
                    ORDER BY user.vNombre ASC
                    LIMIT $start_limit, $results_per_page";
            
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $status = "Disponible";
                $badgeColor = "success"; // Por defecto, color verde para disponible

                if ($row['Status'] == 0) {
                    $status = "Inactivo";
                    $badgeColor = "danger"; // Color rojo para inactivo
                } else if ($row['Status'] == 1) {
                    $status = "Documentos Pendientes";
                    $badgeColor = "warning"; // Color amarillo para documentos pendientes
                }

                echo "<tr class='table-{$badgeColor}'>
                        <td>{$row['vNombre']}</td>
                        <td>{$row['vApellidoP']}</td>
                        <td>{$row['vCorreo']}</td>
                        <td>{$row['nWhats']}</td>
                        <td>{$row['NombreCurso']}</td>
                        <td>-</td>
                        <td><span class='badge bg-{$badgeColor}'>{$status}</span></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <?php
    $sql_count = "SELECT COUNT(*) AS total FROM user";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $total_pages = ceil($row_count['total'] / $results_per_page);

    echo "<nav aria-label='Page navigation example'>
            <ul class='pagination justify-content-center'>";
    
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
    }
    
    echo "</ul></nav>";
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
