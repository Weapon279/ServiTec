<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiTec - Cursos, Talleres y Servicios Tecnologicos.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="recursos/css/piep.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/tarjetaP.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/tarjetaR.css">
  <link rel="stylesheet" type="text/css" href="recursos/css/img.css">



</head>
<body>
    
<ul>
  <li><a href="#home">Inicio</a></li>
  <li><a href="#news">Curso</a></li>
  <li><a  href="#contact">Contacto</a></li>
  <li><a href="#about">Login / Registro</a></li>
</ul>

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
<div>
  <h3  align="center">Reconocimientos</h3>
  <div class="Reconocimiento1" align="center">
    <img src="recursos/img/recono1.webp" alt=recono1 class="d-block" style="width:20%">
</div>
<div class="Reconocimiento2" align="right">
    <img src="recursos/img/recono2.webp" alt=recono2 class="d-block" style="width:20%">
  </div>
</div>

<div class="container p-10 my-10 ">
</div>
</div>

<!--Tarjeta-->
<div class="plan">
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
</body>
</html>