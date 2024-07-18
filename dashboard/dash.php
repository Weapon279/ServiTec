<?php include 'indexa.php'; ?>
<?php
require 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
}

// Función para obtener el conteo de servicios según su estado
function contarServicios($conn, $status) {
    $query = "SELECT COUNT(*) AS total FROM curso WHERE Status = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Obtener datos de los servicios
$serviciosEnCurso = contarServicios($conn, 'Disponible');
$serviciosSinFecha = contarServicios($conn, 'Falta Informacion');
$serviciosCancelados = contarServicios($conn, 'Cancelado');

// Obtener el número de usuarios (alumnos)
$queryUsuarios = "SELECT COUNT(*) AS total FROM alumnos";
$resultUsuarios = $conn->query($queryUsuarios);
$usuarios = $resultUsuarios->fetch_assoc()['total'];

// Obtener los próximos cursos
$sqlProximosCursos = "SELECT id_Curso, NombreCurso, Modalidad, FechaHoraC, FechaHoraA, Status FROM curso";
$resultProximosCursos = $conn->query($sqlProximosCursos);

$sqlCursosVendidos = "SELECT g.id_Grupo,g.ClaveGrupo, c.NombreCurso, c.Modalidad, g.FechaF
                      FROM grupo g
                      JOIN curso c ON g.Fk_id_Curso = c.id_Curso
                      WHERE g.FechaF < NOW()";
$resultCursosVendidos = $conn->query($sqlCursosVendidos);

// Obtener datos para el gráfico de cursos vendidos
$sqlGraficoCursosVendidos = "SELECT NombreCurso, ClaveGrupo, COUNT(*) AS totalVendidos,ClaveGrupo 
                             FROM grupos_finalizados 
                             GROUP BY NombreCurso,ClaveGrupo";
$resultGraficoCursosVendidos = $conn->query($sqlGraficoCursosVendidos);

$cursos = [];
$totales = [];
while($row = $resultGraficoCursosVendidos->fetch_assoc()) {
    $cursos[] = $row['NombreCurso'];
    $totales[] = $row['totalVendidos'];
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
    </style>
</head>
<body>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
    </header>

    <!-- Dashboard Panels -->
    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter">
            <div class="w3-container w3-green w3-padding-16">
                <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><?php echo $serviciosEnCurso; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Servicios en curso</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-yellow w3-padding-16">
                <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><?php echo $serviciosSinFecha; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Servicios sin fecha</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16">
                <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><?php echo $serviciosCancelados; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Servicios Cancelados</h4>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-container w3-orange w3-text-white w3-padding-16">
                <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3><?php echo $usuarios; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Alumnos</h4>
            </div>
        </div>
    </div>

    <!-- Chart and Upcoming Courses -->
    <div class="col-md-12 mt-4">
        <div class="row">
            <!-- Gráfica de cursos vendidos -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Servicios Vendidos</h5>
                        <canvas id="ventasCursosChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Próximos cursos -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Próximos Servicios</h5>
                        <ul id="proximosCursos" class="list-group">
                            <?php while($row = $resultProximosCursos->fetch_assoc()) {
                                echo "<li class='list-group-item'>" . $row['NombreCurso'] . " - " . $row['FechaHoraC'] . "</li>";
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos vendidos con fecha de finalización pasada -->
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Servicios Cancelados</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th>Clave del Grupo</th>
                            <th>Nombre del Curso</th>
                            <th>Modalidad</th>
                            <th>Fecha de Finalización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $resultCursosVendidos ->fetch_assoc()) {
                            echo "<tr>
                                     <td>" . $row['ClaveGrupo'] . "</td>
                                    <td>" . $row['NombreCurso'] . "</td>
                                    <td>" . $row['Modalidad'] . "</td>
                                    <td>" . $row['FechaF'] . "</td>
                                  </tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración del gráfico de ventas de cursos
    const ctx = document.getElementById('ventasCursosChart').getContext('2d');
    const cursos = <?php echo json_encode($cursos); ?>;
    const totales = <?php echo json_encode($totales); ?>;

    const ventasCursosChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: cursos,
            datasets: [{
                label: 'Total Vendidos',
                data: totales,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
            
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Funciones para la barra lateral
var mySidebar = document.getElementById("mySidebar");
var overlayBg = document.getElementById("myOverlay");

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>
</body>
</html>
