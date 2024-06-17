<?php
require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vCorreo = $_POST['vCorreo'];
    $nPass = password_hash($_POST['nPass'], PASSWORD_DEFAULT); 
    $vNombre = $_POST['vNombre'];
    $vApellidoP = $_POST['vApellidoP'];
    $vApellidoM = $_POST['vApellidoM'];
    $nWhats = $_POST['nWhats'];
    $Fk_TypeUser = 4;
    $bStatus = 'Activo'; 

    if (!is_numeric($nWhats) || $nWhats < 0 || $nWhats > 9223372036854775807) {
        echo "Número de WhatsApp no válido.";
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO user (vCorreo, nPass, vNombre, vApellidoP, vApellidoM, nWhats, Fk_TypeUser, bStatus, iFechaHoraC, iFechaHoraA) VALUES (:vCorreo, :nPass, :vNombre, :vApellidoP, :vApellidoM, :nWhats, :Fk_TypeUser, :bStatus, NOW(), NOW())");
        
        $stmt->bindParam(':vCorreo', $vCorreo);
        $stmt->bindParam(':nPass', $nPass);
        $stmt->bindParam(':vNombre', $vNombre);
        $stmt->bindParam(':vApellidoP', $vApellidoP);
        $stmt->bindParam(':vApellidoM', $vApellidoM);
        $stmt->bindParam(':nWhats', $nWhats, PDO::PARAM_INT); 
        $stmt->bindParam(':Fk_TypeUser', $Fk_TypeUser, PDO::PARAM_INT);
        $stmt->bindParam(':bStatus', $bStatus);

        if ($stmt->execute()) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('modal').style.display = 'block';
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2000);
                    });
                  </script>";
        } else {
            echo "Error al registrar el usuario.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body, html {
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .bg-img {
            background-image: url("../recursos/img/img13.jpg");
            min-height: 700px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }

        .container {
            position: absolute;
            right: 0;
            margin: 20px;
            max-width: 300px;
            padding: 16px;
            background-color: white;
        }

        input[type=text], input[type=password], input[type=number] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .btn:hover {
            opacity: 1;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="bg-img">
  <form action="" method="POST" class="container">
    <h1>Registro</h1>
    <label for="vNombre"><b>Nombre</b></label>
    <input type="text" placeholder="Escribe tu Nombre" name="vNombre" required>
    <label for="vApellidoP"><b>Primer Apellido</b></label>
    <input type="text" placeholder="Escribe tu Apellido" name="vApellidoP" required>
    <label for="vApellidoM"><b>Segundo Apellido</b></label>
    <input type="text" placeholder="Escribe tu Apellido" name="vApellidoM">
    <label for="vCorreo"><b>Correo</b></label>
    <input type="text" placeholder="Escribe tu Correo" name="vCorreo" required>
    <label for="nWhats"><b>WhatsApp</b></label>
    <input type="number" placeholder="Escribe Tu WhatsApp" name="nWhats" required>
    <label for="nPass"><b>Contraseña</b></label>
    <input type="password" placeholder="Escribe tu contraseña" name="nPass" required>
    <span class="psw">¿Tienes cuenta? <a href="login.php">Inicia Sesion</a></span>
    <button type="submit" class="btn">Registrarme</button>
  </form>
</div>

<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Usuario registrado con éxito. Inicia sesión</p>
  </div>
</div>

<script>
    // Script para cerrar el modal y redirigir después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modal');
        var span = document.getElementsByClassName('close')[0];

        // Cuando el usuario hace clic en <span> (x), cierra el modal
        span.onclick = function() {
            modal.style.display = 'none';
        }

        // Cuando el usuario hace clic fuera del modal, lo cierra
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    });
</script>

</body>
</html>
