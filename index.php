<?php include 'dashboard/conexion.php';?>
<?php include 'contacto.php';?>


<!DOCTYPE html>
<html>
<head>
<title>IGESEC - Sistema de Gestión de servicios de Educación Continua.</title>
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
</style>
<!-- Fin login -->
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-green-custom w3-card" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button w3-wide">LOGO</a>
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
  <button type="button" data-bs-target="#banner" data-bs-slide-to="0" class="active"></button>
  <button type="button" data-bs-target="#banner" data-bs-slide-to="1"></button>
  <button type="button" data-bs-target="#banner" data-bs-slide-to="2"></button>
</div>

<!-- The slideshow/carousel -->
<div class="carousel-inner">
  <div class="carousel-item active">
    <img src="recursos/img/utem.webp" alt="utem" class="d-block" style="width:100%">
  </div>
  <div class="carousel-item">
    <img src="Recursos/img/scrum.webp" alt="Scrum" class="d-block" style="width:110%">
  </div>
  <div class="carousel-item">
    <img src="Recursos/img/scrum.webp" alt="Scrum" class="d-block" style="width:100%">
  </div>
</div>
<!-- Left and right controls/icons -->
<button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
  <span class="carousel-control-prev-icon"></span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
  <span class="carousel-control-next-icon"></span>
</button>
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
<div class="w3-container" style="padding:128px 16px" id="">
  <h3 class="w3-center">Proximos Cursos</h3>
  <p class="w3-center w3-large">¡INSCRÍBETE AHORA!</p>
    <div class="w3-col l3 m6 w3-margin-bottom">
    <img src="recursos/img/acceso.webp" alt="Ingeniero Juan Manuel Fernandez Alvarez" style="width:100%">

      <div class="w3-card">
        <div class="w3-container">
          <h3>Metodologia Scrum</h3>
          <p class="w3-opacity">Ingeniero Juan Manuel Fernandez Alvarez </p>
          <p>En este curso aprenderan scrum.</p>
          <p>Fecha Inicio 24/04/25</p>
         <p>Termino 24/04/26</p>
         <p>Modalidad: Presencial</p>
        <p>Costo: $999</p>
          <p><button class="w3-button w3-green-custom w3-block"><i class="fa fa-user"></i> ¡Registrarme ahora!</button></p>
        </div>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-card">
        <img src="recursos/img/acceso.webp" alt="Ingeniero Juan Manuel Fernandez Alvarez" style="width:100%">
        <div class="w3-container">
          <h3>Metodologia Scrum</h3>
          <p class="w3-opacity">Ingeniero Juan Manuel Fernandez Alvarez </p>
          <p>En este curso aprenderan scrum.</p>
          <p>Fecha Inicio 24/04/25</p>
         <p>Termino 24/04/26</p>
         <p>Modalidad: Presencial</p>
        <p>Costo: $999</p>
          <p><button class="w3-button w3-green-custom w3-block"><i class="fa fa-user"></i> ¡Registrarme ahora!</button></p>
        </div>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-card">
        <img src="recursos/img/acceso.webp" alt="Ingeniero Juan Manuel Fernandez Alvarez" style="width:100%">
        <div class="w3-container">
          <h3>Metodologia Scrum</h3>
          <p class="w3-opacity">Ingeniero Juan Manuel Fernandez Alvarez </p>
          <p>En este curso aprenderan scrum.</p>
          <p>Fecha Inicio 24/04/25</p>
         <p>Termino 24/04/26</p>
         <p>Modalidad: Presencial</p>
        <p>Costo: $999</p>
          <p><button class="w3-button w3-green-custom w3-block"><i class="fa fa-user"></i> ¡Registrarme ahora!</button></p>
        </div>
      </div>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <div class="w3-card">
        <img src="recursos/img/acceso.webp" alt="Ingeniero Juan Manuel Fernandez Alvarez" style="width:100%">
        <div class="w3-container">
          <h3>Metodologia Scrum</h3>
          <p class="w3-opacity">Experiencia Optima </p>
          <p>En este curso aprenderan scrum.</p>
          <p>Fecha Inicio 24/04/25</p>
         <p>Termino 24/04/26</p>
         <p>Modalidad: Presencial</p>
        <p>Costo: $999</p>
          <p><button class="w3-button w3-green-custom w3-block"><i class="fa fa-user"></i> ¡Registrarme ahora!</button></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Fin Cursos proxims -->


<!-- lista de cursos -->
<div class="w3-container w3-row w3-center w3-green-custom w3-padding-64">
  <div class="w3-quarter">
    <span class="w3-xxlarge">14+</span>
    <br>Cursos
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">55+</span>
    <br>Talleres
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">89+</span>
    <br>Servicios Tecnologicos
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">150+</span>
    <br>Clientes Satisfechos
  </div>
</div>
<!-- fin lista de cursos -->


<!-- Servicios -->
<div class="w3-container" style="padding:128px 16px" id="servicios">
  <h3 class="w3-center">SERVICIOS</h3>
  <p class="w3-center w3-large">Cursos de calidad para gente de calidad</p>

  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-col l3 m6">
      <img src="recursos/img/acceso.webp" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="Desarrollo de habilidad de CEO con este curso impartido por quien tu quieras.">
      <p class="w3-center w3-large">Desarrolla tu habilidad de Ceo</p>
    </div>
    <div class="w3-col l3 m6">
      <img src="recursos/img/acceso.webp" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="con este curso impartido por quien tu quieras.">
        <p class="w3-center w3-large">Tu contabilidad con facilidad</p>
    </div>
    <div class="w3-col l3 m6">
      <img src="recursos/img/acceso.webp" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="con este curso impartido por quien tu quieras.">
        <p class="w3-center w3-large">Matematicas Computacional</p>
    </div>
    <div class="w3-col l3 m6">
      <img src="recursos/img/acceso.webp" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="con este curso impartido por quien tu quieras.">
        <p class="w3-center w3-large">Aprende habilidad basicas</p>
    </div>
  </div>
  <!-- Fin Servicios -->


  
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
          <h2 class="w3-wide">$ 1500</h2>
          <span class="w3-opacity">Por Persona</span>
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
          <h2 class="w3-wide">$ 1000</h2>
          <span class="w3-opacity">Por persona</span>
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
          <h2 class="w3-wide">Contactar</h2>
          <span class="w3-opacity">Por persona</span>
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
    <div style="margin-top:48px">
        <p><i class="fa fa-map-marker fa-fw w3-xxlarge w3-margin-right"></i> Camino hacia las humedades S/N, Salagua, 28869 Manzanillo, Col.</p>
        <p><i class="fa fa-phone fa-fw w3-xxlarge w3-margin-right"></i> Telefono: 314 331 4450 </p>
        <p><i class="fa fa-envelope fa-fw w3-xxlarge w3-margin-right"> </i> Email: utem@utem.com</p>
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

    
    <!-- googlemaps -->
    <center>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.267748586861!2d-104.31920052499501!3d19.13975364996839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8424d64c16a690bd%3A0x14d49ae4c320b692!2sUniversidad%20Tecnol%C3%B3gica%20de%20Manzanillo!5e0!3m2!1ses!2smx!4v1716512186157!5m2!1ses!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </center>
<!-- Footer -->
<footer class="w3-center w3-green-custom w3-padding-10">
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
