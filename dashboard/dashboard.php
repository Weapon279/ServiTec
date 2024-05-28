<?php include 'conexion.php'; ?>
<?php include 'index.php'; ?>
<div class="container mt-5">
    <h2>Dashboard</h2>
    <div class="row">
        <!-- Gráfica de cursos vendidos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cursos Vendidos</h5>
                    <canvas id="ventasCursosChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Próximos cursos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Próximos Cursos</h5>
                    <ul id="proximosCursos" class="list-group">
                        <!-- Listar próximos cursos desde la base de datos -->
                        <?php
                        $sql = "SELECT NombreCurso, FechaI FROM grupo INNER JOIN curso ON grupo.Fk_id_Curso = curso.id_Curso WHERE FechaI > NOW() ORDER BY FechaI ASC";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<li class='list-group-item'>" . $row['NombreCurso'] . " - " . $row['FechaI'] . "</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Cursos sin fecha -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cursos Sin Fecha</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre del Curso</th>
                                <th>Descripción</th>
                                <th>Docente</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT NombreCurso, DescripcionCurso, DocenteConvoca, CostoCurso FROM curso LEFT JOIN convocatoria ON curso.Fk_id_ofer = convocatoria.Id_Convoca WHERE curso.FechaHoraC IS NULL";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row['NombreCurso'] . "</td>
                                        <td>" . $row['DescripcionCurso'] . "</td>
                                        <td>" . $row['DocenteConvoca'] . "</td>
                                        <td>" . $row['CostoCurso'] . "</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
