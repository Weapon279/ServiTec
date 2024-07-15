<?php
require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vCorreo = $_POST['vCorreo'];
    $nPass = password_hash($_POST['nPass'], PASSWORD_DEFAULT); 
    $vNombre = $_POST['vNombre'];
    $vApellidoP = $_POST['vApellidoP'];
    $vApellidoM = $_POST['vApellidoM'];
    $nWhats = $_POST['nWhats'];
    $curp = $_POST['curp']; // Obtener el CURP del formulario
    $Fk_TypeUser = 1;
    $bStatus = 'Activo'; 

    if (!is_numeric($nWhats) || $nWhats < 0 || $nWhats > 9223372036854775807) {
        echo "Número de WhatsApp no válido.";
        exit();
    }

    // Validar que el CURP sea único
    $stmt_check_curp = $conn->prepare("SELECT COUNT(*) FROM user WHERE curp = :curp");
    $stmt_check_curp->bindParam(':curp', $curp);
    $stmt_check_curp->execute();
    
    if ($stmt_check_curp->fetchColumn() > 0) {
        echo "El CURP ya está en uso. Por favor, ingrese uno diferente.";
        exit();
    }

    try {
        $conn->beginTransaction(); // Inicia una transacción
        
        // Insertar usuario en la tabla user
        $stmt_user = $conn->prepare("INSERT INTO user (vCorreo, nPass, vNombre, vApellidoP, vApellidoM, nWhats, curp, Fk_TypeUser, bStatus, iFechaHoraC, iFechaHoraA) VALUES (:vCorreo, :nPass, :vNombre, :vApellidoP, :vApellidoM, :nWhats, :curp, :Fk_TypeUser, :bStatus, NOW(), NOW())");
        
        $stmt_user->bindParam(':vCorreo', $vCorreo);
        $stmt_user->bindParam(':nPass', $nPass);
        $stmt_user->bindParam(':vNombre', $vNombre);
        $stmt_user->bindParam(':vApellidoP', $vApellidoP);
        $stmt_user->bindParam(':vApellidoM', $vApellidoM);
        $stmt_user->bindParam(':nWhats', $nWhats, PDO::PARAM_INT); 
        $stmt_user->bindParam(':curp', $curp);
        $stmt_user->bindParam(':Fk_TypeUser', $Fk_TypeUser, PDO::PARAM_INT);
        $stmt_user->bindParam(':bStatus', $bStatus);

        if ($stmt_user->execute()) {
            // Obtener el ID del usuario insertado
            $Fk_id_User = $conn->lastInsertId();
            
            // Insertar en la tabla alumnos
            $stmt_alumno = $conn->prepare("INSERT INTO alumnos (Fk_id_User, Status, FechaHoraC, FechaHoraA) VALUES (:Fk_id_User, 1, NOW(), NOW())");
            $stmt_alumno->bindParam(':Fk_id_User', $Fk_id_User, PDO::PARAM_INT);
            $stmt_alumno->execute();
            
            $conn->commit(); // Confirmar la transacción

            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('modal').style.display = 'block';
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2000);
                    });
                  </script>";
            
            // Notificación para el administrador
            $mensaje = "Nuevo usuario registrado: {$vNombre} {$vApellidoP}";
            $tipo = "registro_usuario";

            $sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (:tipo, :mensaje)";
            $stmt_notif = $conn->prepare($sql);
            $stmt_notif->bindParam(':tipo', $tipo);
            $stmt_notif->bindParam(':mensaje', $mensaje);
            $stmt_notif->execute();
        } else {
            echo "Error al registrar el usuario.";
        }
    } catch (PDOException $e) {
        $conn->rollBack(); // Revertir la transacción en caso de error
        echo "Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> <!-- Enlace al archivo CSS -->
</head>
<style>
    /* style.css */

/* Ajustes generales para el body */
body {
    font-family: 'Raleway', sans-serif;
}

/* Estilo para el contenedor principal */
.container {
    max-width: 100%;
    padding: 20px;
}

/* Estilo para la tarjeta de registro */
.card {
    border-radius: 10px;
}

/* Estilo para los botones */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

/* Estilo para el enlace de inicio de sesión */
.psw a {
    color: #007bff;
}

.psw a:hover {
    text-decoration: underline;
}

/* Estilo para el modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    text-align: center;
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
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Registro</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="registro.php">
                <div class="mb-3">
                    <label for="vNombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="vNombre" name="vNombre" placeholder="Escribe tu Nombre" required>
                </div>
                <div class="mb-3">
                    <label for="vApellidoP" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="vApellidoP" name="vApellidoP" placeholder="Escribe tu Apellido" required>
                </div>
                <div class="mb-3">
                    <label for="vApellidoM" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="vApellidoM" name="vApellidoM" placeholder="Escribe tu Apellido">
                </div>
                <div class="mb-3">
                    <label for="curp" class="form-label">CURP</label>
                    <input type="text" class="form-control" id="curp" name="curp" placeholder="Escribe tu CURP" required>
                </div>

                <div class="mb-3">
                    <label for="vCorreo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="vCorreo" name="vCorreo" placeholder="Escribe tu Correo" required>
                </div>
                <div class="mb-3">
                    <label for="nWhats" class="form-label">WhatsApp</label>
                    <input type="number" class="form-control" id="nWhats" name="nWhats" placeholder="Escribe Tu WhatsApp" required>
                </div>
                <div class="mb-3">
                    <label for="nPass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="nPass" name="nPass" placeholder="Escribe tu contraseña" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                </div>
                <div class="text-center">
                    <span class="psw">¿Tienes cuenta? <a href="login.php">Inicia Sesión</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Usuario registrado con éxito. Inicia sesión</p>
        </div>
    </div>

    <script>
        // Script para cerrar el modal y redirigir después de 2 segundos
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modal');
            var span = document.getElementsByClassName('close')[0];

            if (modal.style.display == 'block') {
                setTimeout(function() {
                    modal.style.display = 'none';
                    window.location.href = 'login.php';
                }, 2000);
            }

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
