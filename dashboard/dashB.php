

<?php
include '../modelo/conexion.php';
include 'index.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
    </style>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-green w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();">
        <i class="fa fa-bars"></i> &nbsp;Menu
    </button>
    <span class="w3-bar-item w3-right">Logo</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
        </div>
        <div class="w3-col s8 w3-bar">
            <span>Bienvenido, <strong>Alan</strong></span><br>
            <a href="mensaje.php" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
            <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
            <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Dashboard</h5>
    </div>
    <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu">
            <i class="fa fa-remove fa-fw"></i>&nbsp; Cerrar Menu
        </a>
        <a href="a/dashB.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>&nbsp; Inicio</a>
        <a href="a/pefilA.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>&nbsp; Perfil</a>
        <a href="a/diplomasA.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>&nbsp; Diplomas</a>
    </div>
</nav>

<!-- Main content -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <?php
    // Contenido específico para el administrador
    if ($_SESSION['user_type'] == 'Admin') {
    ?>
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
    <?php
    } else {
        // Contenido para aspirantes y alumnos
    ?>
    <div class="w3-container w3-row">
        <h2>Bienvenido al Dashboard</h2>
        <!-- Aquí puedes agregar contenido específico para aspirantes y alumnos -->
        <!-- Ejemplo de diplomas -->
        <div class="w3-container w3-card w3-white w3-margin-bottom">
            <h4 class="w3-text-grey w3-padding-16"><i class="fa fa-bullseye fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Diplomas</h4>
            <div class="w3-container">
                <h5 class="w3-opacity"><b>Curso de PHP</b></h5>
                <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2021 - Presente</h6>
                <p>Diploma otorgado por completar el curso de PHP</p>
                <hr>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
