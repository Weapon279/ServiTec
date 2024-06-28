<?php
session_start();
require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vCorreo = $_POST['vCorreo'];
    $nPass = $_POST['nPass'];

    // Consulta para obtener el usuario y tipo de usuario
    $stmt = $conn->prepare("SELECT id_User, Fk_TypeUser, vNombre, vApellidoP, vApellidoM, vCorreo, nPass FROM user WHERE vCorreo = :vCorreo");
    $stmt->bindParam(':vCorreo', $vCorreo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($nPass, $user['nPass'])) {
        // Verificar si ya hay una sesión activa
        $stmt_session = $conn->prepare("SELECT session_id FROM sesion WHERE user_id = :userId");
        $stmt_session->bindParam(':userId', $user['id_User']);
        $stmt_session->execute();
        $active_session = $stmt_session->fetch(PDO::FETCH_ASSOC);

        if ($active_session) {
            // Si hay una sesión activa, cerrarla
            $stmt_delete = $conn->prepare("DELETE FROM sesion WHERE user_id = :userId");
            $stmt_delete->bindParam(':userId', $user['id_User']);
            $stmt_delete->execute();
        }

        // Crear una nueva sesión
        session_regenerate_id(true);
        $sessionId = session_id();
        $stmt_insert = $conn->prepare("INSERT INTO sesion (user_id, session_id) VALUES (:userId, :sessionId)");
        $stmt_insert->bindParam(':userId', $user['id_User']);
        $stmt_insert->bindParam(':sessionId', $sessionId);
        $stmt_insert->execute();

        // Establecer las variables de sesión
        $_SESSION['userId'] = $user['id_User'];
        $_SESSION['username'] = $user['vNombre'];
        $_SESSION['userType'] = $user['Fk_TypeUser'];

        // Redirigir al dashboard según el tipo de usuario
        if ($user['Fk_TypeUser'] == 4) {
            header("Location: dashboard/dashb.php");
        } elseif ($user['Fk_TypeUser'] == 3) {
            header("Location: dashboard/dash.php");
        } else {
            header("Location: dashboard/dashb.php");
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    /* Ajustes generales para el body */
    body {
        font-family: 'Raleway', sans-serif;
    }

    /* Estilo para el contenedor principal */
    .container {
        max-width: 100%;
        padding: 20px;
    }

    /* Estilo para la tarjeta de inicio de sesión */
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

    /* Estilo para el enlace de registro */
    .psw a {
        color: #007bff;
    }

    .psw a:hover {
        text-decoration: underline;
    }
</style>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="vCorreo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="vCorreo" name="vCorreo" required>
                </div>
                <div class="mb-3">
                    <label for="nPass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="nPass" name="nPass" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </div>
                <div class="text-center">
                    <span class="psw">¿No tienes cuenta? <a href="registro.php">Registrarte</a></span>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="logout.js"></script>
</body>
</html>
