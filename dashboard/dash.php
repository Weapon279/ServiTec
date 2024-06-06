<?php include 'conexion.php'; ?>
<?php include 'indexa.php'; ?>


<!DOCTYPE html>
<html>
<head>
<title>Admin</title>
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



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i>Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-green w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Servicios en curso.</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-yellow w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Servicios sin fecha</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>23</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Servicios Cancelados</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>50</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Usuarios</h4>
      </div>
    </div>
  </div>


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
                <!-- Fin Gráfica de cursos vendidos -->

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
                <!-- Fin Próximos cursos -->

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
        <!-- Fin Cursos sin fecha -->


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