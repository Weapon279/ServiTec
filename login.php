<?php
session_start();
require 'modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vCorreo = $_POST['vCorreo'];
    $nPass = $_POST['nPass'];

    // Consulta para obtener el usuario y tipo de usuario
    $stmt = $pdo->prepare("SELECT id_User, Fk_TypeUser, vNombre, vApellidoP, vApellidoM, vCorreo, nPass FROM user WHERE vCorreo = :vCorreo");
    $stmt->bindParam(':vCorreo', $vCorreo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($nPass, $user['nPass'])) {
        // Establecer las variables de sesión
        $_SESSION['userId'] = $user['id_User'];
        $_SESSION['username'] = $user['vNombre'];
        $_SESSION['userType'] = $user['Fk_TypeUser'];

        // Redirigir al dashboard según el tipo de usuario
        if ($user['Fk_TypeUser'] == 4) {
            header("Location: dashboard/a/dashboard.php");
        } elseif ($user['Fk_TypeUser'] == 3) {
            header("Location: dashboard/dash.php");
        } else {
            header("Location: dashboard/dashboard.php");
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <h2 class="mt-5">Iniciar Sesión</h2>
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
            <span class="psw">¿Tienes cuenta? <a href="registro.php">Registrarte</a></span>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</body>
</html>
