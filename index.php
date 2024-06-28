<?php
session_start();
require 'modelo/conexion.php';

try {
    $sql = "SELECT 
                c.id_Curso,
                c.NombreCurso,
                c.Perfil,
                c.DescripcionCurso,
                c.FechaHoraC,
                c.FechaHoraA,
                c.NombreDoc,
                c.Modalidad,
                c.CostoCurso,
                c.ImagenCurso,
                o.NombreOfer
            FROM 
                curso c
            JOIN 
                oferta o ON c.Fk_id_ofer = o.id_ofer
            WHERE 
                c.Status = 'Falta Informacion'
            ORDER BY c.FechaHoraC ASC
            LIMIT 4";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php


try {
    $sql = "SELECT 
                c.id_Curso,
                c.NombreCurso,
                c.Perfil,
                c.DescripcionCurso,
                c.FechaHoraC,
                c.FechaHoraA,
                c.NombreDoc,
                c.Modalidad,
                c.CostoCurso,
                c.ImagenCurso,
                o.NombreOfer
            FROM 
                curso c
            JOIN 
                oferta o ON c.Fk_id_ofer = o.id_ofer
            WHERE 
                c.Status = 'Disponible'
            ORDER BY c.FechaHoraC ASC
            LIMIT 4";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $cursosD = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php

try {


// Obtener conteo de cursos
$sqlCursos = "SELECT COUNT(*) AS totalCursos FROM curso WHERE TipoSer = 'Curso' AND Status IN ('Disponible', 'Concluir', 'Suspender', 'Falta Informacion')";
$stmtCursos = $conn->prepare($sqlCursos);
$stmtCursos->execute();
$totalCursos = $stmtCursos->fetch(PDO::FETCH_ASSOC)['totalCursos'];

// Obtener conteo de talleres
$sqlTalleres = "SELECT COUNT(*) AS totalTalleres FROM curso WHERE TipoSer = 'Taller' AND Status IN ('Disponible', 'Concluir', 'Suspender', 'Falta Informacion')";
$stmtTalleres = $conn->prepare($sqlTalleres);
$stmtTalleres->execute();
$totalTalleres = $stmtTalleres->fetch(PDO::FETCH_ASSOC)['totalTalleres'];

// Obtener conteo de servicios tecnológicos
$sqlServicios = "SELECT COUNT(*) AS totalServicios FROM curso WHERE TipoSer = 'Servicio Tecnologico' AND Status IN ('Disponible', 'Concluir', 'Suspender', 'Falta Informacion')";
$stmtServicios = $conn->prepare($sqlServicios);
$stmtServicios->execute();
$totalServicios = $stmtServicios->fetch(PDO::FETCH_ASSOC)['totalServicios'];


  // Obtener conteo de clientes satisfechos
  $sqlClientes = "SELECT COUNT(DISTINCT Fk_id_user) AS totalClientes FROM diplomas";
  $stmtClientes = $conn->prepare($sqlClientes);
  $stmtClientes->execute();
  $totalClientes = $stmtClientes->fetch(PDO::FETCH_ASSOC)['totalClientes'];

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<?php
$directory = 'dashboard/img/';
$images = glob($directory . '*.{jpg,webp,web,jpeg,png,gif}', GLOB_BRACE);
?>

<?php include 'modelo/conexion.php';?>
<?php include 'contacto.php';?>



<!DOCTYPE html>
<html>
<head>
<title>SIGESEC - Sistema de Gestión de servicios de Educación Continua.</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
  background-size: cover;
  background-image: url("/w3images/mac.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
/* Colores principales */
:root {
    --color-azul-oscuro: #2b4c9b;
    --color-verde-azulado: #00AA8A;
    --color-gris-claro: #aeaeae;
    --color-amarillo-dorado: #c59507;
    --color-blanco: #ffffff;
    --color-negro: #000000;
}

/* Clases W3.CSS personalizadas */
.w3-green-custom {
    background-color: var(--color-verde-azulado) !important;
}

/* Estilos generales */
body {
    background-color: var(--color-blanco);
    color: var(--color-negro);
    font-family: Arial, sans-serif;
}

/* Barra de navegación */
nav {
    background-color: var(--color-azul-oscuro);
    color: var(--color-blanco);
}

nav a {
    color: var(--color-blanco);
    text-decoration: none;
    padding: 10px;
}

nav a:hover {
    color: var(--color-verde-azulado);
}

/* Botones */
button {
    background-color: var(--color-verde-azulado);
    color: var(--color-blanco);
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}


/* Destacados */


/* Secciones */
.section {
    background-color: var(--color-gris-claro);
    padding: 20px;
    margin: 10px 0;
    border-radius: 5px;
}

/* Enlaces */
a {
    color: var(--color-azul-oscuro);
    text-decoration: none;
}

a:hover {
    color: var(--color-verde-azulado);
}


</style>
<!-- Login -->
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
login.button {
  background-color: #00aa8a;
  color: BLACK;
  
  padding: 14px 20px;
  width: 100%;
  border: none;
  cursor: pointer;

}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}

/* Banner */

/* Ajustes generales para el body */
body {
    font-family: 'Raleway', sans-serif;
}

/* Estilo para las imágenes del carrusel */
.carousel-inner img {
    width: 1920px; /* Ancho fijo */
    height: 968px; /* Altura fija */
    object-fit: cover; /* Asegura que la imagen cubra el área sin distorsión */
}

/* Estilo para el contenedor del carrusel */
.carousel {
    margin-top: 20px;
}

/* Estilos adicionales para mejorar la apariencia */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    padding: 10px;
}

.carousel-indicators li {
    background-color: rgba(0, 0, 0, 0.5);
}



</style>

<!-- Fin login -->
</head>
<!-- Margen de tabla y menu lateral -->
<div class="w3-main" style="margin-left:px;margin-top:60px;">
<!--Fin de margen -->

<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-green-custom w3-card" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button w3-wide">SIGESEC</a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <a href="#acercade" class="w3-bar-item w3-button">ACERCA DE</a>
      <a href="#servicios" class="w3-bar-item w3-button"><i class="fa fa-th"></i> SERVICIOS</a>
      <a href="login.php" class="w3-bar-item w3-button" class="fa fa-user"><i class="fa fa-user"></i> LOGIN</a>
      <a href="#contacto" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i> CONTACTO</a>
    </div>

    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>


<!-- Header with full-height image -->
<!-- Carousel -->
<div id="banner" class="carousel slide" data-bs-ride="carousel">

<!-- Indicators/dots -->
<div class="carousel-indicators">

</div>



    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $active = 'active';
            foreach ($images as $image) {
                echo '<div class="carousel-item ' . $active . '">';
                echo '<img src="' . $image . '" alt="Image" class="d-block w-100">';
                echo '</div>';
                $active = '';
            }
            ?>
        </div>

    </div>

</div>



<!-- Cursos, talleres y servicios -->
<div class="w3-container" style="padding:128px 16px" id="acercade">
  <h3 class="w3-center">CURSOS, TALLERES Y SERVICIOS TECNOLOGICOS</h3>
  <p class="w3-center w3-large">Todo en un solo lugar #SoyUtem</p>
  <div class="w3-row-padding w3-center" style="margin-top:64px">
    <div class="w3-quarter">
      <i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
      <p class="w3-large">Servicios Tecnologicos</p>

    </div>
    <div class="w3-quarter">
      <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Habilidades blandas</p>

    </div>
    <div class="w3-quarter">
      <i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Contabilidad</p>

    </div>
    <div class="w3-quarter">
      <i class="fa fa-cog w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Scrum</p>
    </div>
  </div>
</div>
<!-- fin de Cursos, talleres y servicios -->


<!-- Reconocimientos -->
<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <div class="w3-row-padding">
    <div class="w3-col m6">
      <h3>Reconocimientos.</h3>
      <p>Felicidades al Ingeniero Giovanni por su accenso<br>tempor incididunt ut labore et dolore.</p>
      <p><a href="#servicios" class="w3-button w3-green-custom"><i class="fa fa-th"> </i> Ver Servicios</a></p>
    </div>
    <div class="w3-col m6">
      <img class="w3-image w3-round-large" src="recursos/img/acceso.webp" alt="Buildings" width="250" height="250">
    </div>
  </div>
</div>
<!-- fin Reconocimientos -->


<!-- Cursos proxims -->

<!-- Cursos próximos -->
<div class="w3-container" style="padding:128px 16px" id="">
  <h3 class="w3-center">Próximos Cursos</h3>
  <p class="w3-center w3-large">¡INSCRÍBETE AHORA!</p>

  <?php if (!empty($cursos)) { ?>
    <?php foreach ($cursos as $curso) { ?>
      <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="<?php echo htmlspecialchars($curso['ImagenCurso'] ?? 'default.webp ,default.webp default,jpg'); ?>" alt="<?php echo htmlspecialchars($curso['NombreCurso'] ?? ''); ?>" style="width:100%">        <div class="w3-card">
          <div class="w3-container">
            <h3><?php echo htmlspecialchars($curso['NombreCurso'] ?? ''); ?></h3>
            <p class="w3-opacity"><?php echo htmlspecialchars($curso['NombreOfer'] ?? ''); ?></p>
            <p><?php echo htmlspecialchars($curso['DescripcionCurso'] ?? ''); ?></p>
            <p>Docente: <?php echo htmlspecialchars($curso['NombreDoc'] ?? ''); ?></p>
            <p>Fecha Inicio: <?php echo htmlspecialchars($curso['FechaHoraC'] ?? ''); ?></p>
            <p>Termino: <?php echo htmlspecialchars($curso['FechaHoraA'] ?? ''); ?></p>
            <p>Modalidad: <?php echo htmlspecialchars($curso['Modalidad'] ?? ''); ?></p>
            <p>Costo: $<?php echo htmlspecialchars($curso['CostoCurso'] ?? ''); ?></p>
            <p><a href="login.php" class="w3-button w3-green-custom w3-block"><i class="fa fa-user"> </i> ¡Registrarme ahora!</a></p>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p class="w3-center">No hay cursos disponibles en este momento.</p>
  <?php } ?>
</div>
<!-- Fin Cursos próximos -->


<!-- lista de cursos -->
<div class="w3-container w3-row w3-center w3-green-custom w3-padding-64">
  <div class="w3-quarter">
    <span class="w3-xxlarge"><?php echo $totalCursos; ?>+</span>
    <br>Cursos
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge"><?php echo $totalTalleres; ?>+</span>
    <br>Talleres
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge"><?php echo $totalServicios; ?>+</span>
    <br>Servicios Tecnologicos
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge"><?php echo $totalClientes; ?>+</span>
    <br>Clientes Satisfechos
  </div>
</div>
<!-- fin lista de cursos -->


<!-- Servicios -->
<div class="w3-container" style="padding:128px 16px" id="servicios">
  <h3 class="w3-center">SERVICIOS</h3>
  <p class="w3-center w3-large">Cursos de calidad para gente de calidad</p>

  <div class="w3-row-padding" style="margin-top:64px">
  <?php if (!empty($cursosD)) { ?>
    <?php foreach ($cursosD as $curso) { ?>
      <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="<?php echo htmlspecialchars($curso['ImagenCurso'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($curso['NombreCurso'] ?? ''); ?>" style="width:100%">        <div class="w3-card">
          <div class="w3-container">
            <h3><?php echo htmlspecialchars($curso['NombreCurso'] ?? ''); ?></h3>
            <p class="w3-opacity"><?php echo htmlspecialchars($curso['NombreOfer'] ?? ''); ?></p>
            <p><?php echo htmlspecialchars($curso['DescripcionCurso'] ?? ''); ?></p>
            <p>Docente: <?php echo htmlspecialchars($curso['NombreDoc'] ?? ''); ?></p>
            <p>Modalidad: <?php echo htmlspecialchars($curso['Modalidad'] ?? ''); ?></p>
            <p>Costo: $<?php echo htmlspecialchars($curso['CostoCurso'] ?? ''); ?></p>
            <p><a href="login.php" class="w3-button w3-green-custom w3-block"><i class="fa fa-user"> </i> ¡Registrarme ahora!</a></p>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p class="w3-center">No hay cursos disponibles en este momento.</p>
  <?php } ?>
  </div>
</div>

<!-- Fin Servicios -->  <!-- Fin Servicios -->
  </div>
</div>

<!-- Modal for full size images on click-->
<div id="modal01" class="w3-modal w3-black" onclick="this.style.display='none'">
  <span class="w3-button w3-xxlarge w3-black w3-padding-large w3-display-topright" title="Close Modal Image">×</span>
  <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
    <img id="img01" class="w3-image">
    <p id="caption" class="w3-opacity w3-large"></p>
  </div>
</div>



<!-- Paquetes -->
<div class="w3-container w3-center w3-dark-grey" style="padding:128px 16px" id="pricing">
  <h3>PAQUETES</h3>
  <p class="w3-large">Todo para tu equipo de trabajo.</p>
  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-third w3-section">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-green-custom w3-xlarge w3-padding-32">ESCUELAS</li>
        <li class="w3-padding-16"><b>Cupo</b> 10 Personas</li>
        <li class="w3-padding-16"><b>10</b> Aire Condicionado</li>
        <li class="w3-padding-16"><b>10</b> Constancias</li>
        <li class="w3-padding-16">
        </li>
        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-green-custom w3-padding-large">Contactar</button>
        </li>
      </ul>
    </div>
    <div class="w3-third">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-gold w3-xlarge w3-padding-48">Empresas</li>
        <li class="w3-padding-16"><b>Cupo</b> 25 Personas</li>
        <li class="w3-padding-16"><b>10</b> Aire Condicionado</li>
        <li class="w3-padding-16"><b>10</b> Constancias</li>
        <li class="w3-padding-16"><b>Soporte </b> En todo momento </li>

        <li class="w3-padding-16">
        </li>
        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-green-custom w3-padding-large">Contactar</button>
        </li>
      </ul>
    </div>
    <div class="w3-third w3-section">
      <ul class="w3-ul w3-white w3-hover-shadow">
        <li class="w3-green-custom w3-xlarge w3-padding-32">Personalizado</li>
        <li class="w3-padding-16"><b>Cupo</b> Contactar</li>
        <li class="w3-padding-16"><b>10</b> Aire Condicionado</li>
        <li class="w3-padding-16"><b>10</b> Constancias</li>
        <li class="w3-padding-16"><b>Soporte </b> En todo momento </li>
        <li class="w3-padding-16">
        </li>
        <li class="w3-light-grey w3-padding-24">
          <button class="w3-button w3-green-custom w3-padding-large">Contactar</button>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Fin Paquetes -->


<!-- Contacto -->
<div class="w3-container w3-light-grey" style="padding:128px 16px" id="contacto">
    <h3 class="w3-center">CONTACTO</h3>
    <p class="w3-center w3-large">Mantengámonos en contacto. Mandanos un mensaje:</p>
        <br>
        <form action="contacto.php" method="POST">
            <p><input class="w3-input w3-border" type="text" placeholder="Nombre" required name="Nombre"></p>
            <p><input class="w3-input w3-border" type="email" placeholder="Correo Electrónico" required name="CorreoElectronico"></p>
            <p><input class="w3-input w3-border" type="text" placeholder="Asunto" required name="Asunto"></p>
            <p><textarea class="w3-input w3-border" placeholder="Mensaje" required name="Mensaje"></textarea></p>
            <p>
                <button class="w3-button w3-green-custom" type="submit">
                    <i class="fa fa-paper-plane"></i> ENVIAR MENSAJE
                </button>
            </p>
        </form>
    </div>
</div>
    <!-- fin Contacto --> 

<!-- Footer -->
 
<footer class="w3-center w3-green-custom w3-padding-10">
<div style="margin-top:48px">
        <p><i class="fa fa-map-marker fa-fw w3-xxlarge w3-margin-right"></i> Camino hacia las humedades S/N, Salagua, 28869 Manzanillo, Col.</p>
        <p><i class="fa fa-phone fa-fw w3-xxlarge w3-margin-right"></i> Telefono: 314 331 4450 </p>
        <p><i class="fa fa-envelope fa-fw w3-xxlarge w3-margin-right"> </i> Email: utem@utem.com</p>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  
  <p> <a href="https://utem.edu.mx/" title="W3.CSS" target="_blank" class="w3-hover-text-green">Univiersidad Tecnologica de Manzanillo</a></p>
</footer>
   </div>


<script>
// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}


// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>
