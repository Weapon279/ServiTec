<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiTec - Cursos, Talleres y Servicios Tecnologicos.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css"
    href="//fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800%7CPoppins:300,400,700">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="recursos/css/tarjetaP.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/tarjetaR.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/img.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/estilo.css>
  <link rel="stylesheet" type="text/css" href="recursoscss/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="recursoscss/fonts.css">
  <link rel="stylesheet" type="text/css" href="recursoscss/style.css" id="main-styles-link">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>
       footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    .carousel-inner img {
      width: 100%; /* Set width to 100% */
      min-height: 200px;
    }

    /* Hide the carousel text when the screen is less than 600 pixels wide */
    @media (max-width: 600px) {
      .carousel-caption {
        display: none; 
      }
    }
 
    .ie-panel {
      display: none;
      background: #212121;
      padding: 10px 0;
      box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
      clear: both;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    html.ie-10 .ie-panel,
    html.lt-ie-10 .ie-panel {
      display: block;
    }
  </style>
  <style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

#navbar {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 90px 10px;
  transition: 0.4s;
  position: fixed;
  width: 100%;
  top: 0;
  z-index: 99;
}

#navbar a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

#navbar #logo {
  font-size: 35px;
  font-weight: bold;
  transition: 0.4s;
}

#navbar a:hover {
  background-color: #ddd;
  color: black;
}

#navbar a.active {
  background-color: dodgerblue;
  color: white;
}

#navbar-right {
  float: right;
}

@media screen and (max-width: 580px) {
  #navbar {
    padding: 20px 10px !important;
  }
  #navbar a {
    float: none;
    display: block;
    text-align: left;
  }
  #navbar-right {
    float: none;
  }
}
</style>

</head>

<body>
<div id="navbar">
  <a href="/servitec/ServiTec/" id="logo">ServiTec</a>
  <div id="navbar-right">
    <a class="active" href="/servitec/ServiTec/">Inicio</a>
    <a class="curso" href="#curso">Curso</a>
    <a href="#contacto">Contacto</a>
    <a href="#login">Login/Registro</a>
  </div>
</div>

 
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
    <img src="recursos/img/scrum.webp" alt="Scrum" class="d-block" style="width:110%">
  </div>
  <div class="carousel-item">
    <img src="recursos/img/scrum.webp" alt="Scrum" class="d-block" style="width:100%">
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


<!--Cursos, Talleres y Servicios Tecnologicos -->
<div class="container p-10 my-10 ">
<h2 align="center">Cursos, Talleres y Servicios Tecnologicos</h2>
<center class="cts">
    <div>
      <p> Curso Scrum </p>
      <div class="img" id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
      <img src="recursos/img/servi1.webp" width="100px" height="90px">
      </div>
    </div>
    
    <div>
      <p> Taller de habilidad blandas </p>
          <div class="img" id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
          <img src="recursos/img/servi2.webp" width="100px" height="90px">
      </div>
    </div>
    
    <div>
      <p> Servicios Tecnologicos </p>
      <div class="img" id="div3" ondrop="drop(event)" ondragover="allowDrop(event)">
        <img src="recursos/img/servi3.webp" width="100px" height="90px">
      </div> 
     </div>
</center>

<!--Reconocimientos-->
<div class="container p-10 my-10 ">
<h2 align="center">Reconocimientos</h2>
<center class="cts">
    <div>
      <div class="img" id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
      <img src="recursos/img/recono2.webp" width="100px" height="90px">
      </div>
    </div>
    
    <div>
          <div class="img" id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
          <img src="recursos/img/recono1.webp" width="100px" height="90px">
      </div>
    </div>
    
    <div>
      <div class="img" id="div3" ondrop="drop(event)" ondragover="allowDrop(event)">
        <img src="recursos/img/recono2.webp" width="100px" height="90px">
      </div> 
     </div>
</center>

<!--Tarjeta--><!--Cursos, Talleres y Servicios Tecnologicos -->
<div class="container p-10 my-10 ">
<h2 align="center">Cursos, Talleres y Servicios Tecnologicos</h2>

  <!--Tarjeta #1-->
  
<div class="plan" id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
		<div class="inner">
			<span class="pricing">
				<span>
					$999 <small>mxn</small>
				</span>
			</span>
			<p class="title">MATEMATICAS COMPUTACIONAL.</p>
			<p class="info">Aprenderemos como caperusita utiliza las mastematicas computacional para escapar del lobo.</p>
			<ul class="features">
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span><strong>Cupo: </strong> 20/20</span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Modalidad: <strong>Precensial</strong></span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Reconocimiento</span>
				</li>
			</ul>
			<div class="action">
			<a class="button" href="login.php">
				Registrarme
			</a>
			</div>
		</div>
	</div>
</div>
  <!--Fin tarjeta #1-->
<!--Fin tarjeta-->

    <!--Pie de pagina -->
    
  </div>
  <footer class="container-fluid text-center">Universidad Tecnologica De Manzanillo @ Todos los derechos Reservados.</footer>
</body>
<script>
// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    document.getElementById("navbar").style.padding = "30px 10px";
    document.getElementById("logo").style.fontSize = "25px";
  } else {
    document.getElementById("navbar").style.padding = "80px 10px";
    document.getElementById("logo").style.fontSize = "35px";
  }
}
</script>
</html>