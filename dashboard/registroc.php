<?php
include 'conexion.php';
session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $curso_id = $_POST['curso_id'];
    $usuario_id = $_SESSION['id_User'];

    // Insertar el interés del aspirante en la tabla intereses
    $sql = "INSERT INTO intereses (Fk_id_User, Status, NombreInteres, FechaHoraC) VALUES (?, 0, '', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    if ($stmt->execute()) {
        echo "Interés registrado con éxito";
        header("Location: registroc.php"); 
    } else {
        echo "Error al registrar el interés";
    }
    exit();
}
?>

<?php
include 'conexion.php';
session_start();

// Tu código de registro en grupo aquí

// Generar notificación para el administrador
$mensaje = "Nuevo aspirante registrado en grupo: {clave del grupo}";
$tipo = "registro_grupo";

$sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $tipo, $mensaje);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Aspirantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Registro de Aspirantes</h1>
        <form method="POST" action="registroc.php">
            <div class="mb-3">
                <label for="curso_id" class="form-label">Seleccione el Curso</label>
                <select id="curso_id" name="curso_id" class="form-select" required>
                    <?php
                    $sql = "SELECT id_Curso, NombreCurso FROM curso WHERE Status = 'Disponible'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_Curso']}'>{$row['NombreCurso']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Interés</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
