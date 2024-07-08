<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require 'conexion.php';

// Variables para almacenar los valores del formulario
$nombrePaquete = '';
$cupo = 0;
$aireAcondicionado = 0;
$constancias = 0;
$soporte = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombrePaquete = $_POST['nombre'];
    $cupo = $_POST['cupo'];
    $aireAcondicionado = $_POST['aire_condicionado'];
    $constancias = $_POST['constancias'];
    $soporte = $_POST['soporte'];

    // Validación (puedes agregar más validaciones según tus necesidades)

    // Insertar los datos en la base de datos
    try {
        $sql = "INSERT INTO paquetes (NombrePaquete, Cupo, AireCondicionado, Constancias, Soporte) 
                VALUES (:nombre, :cupo, :aire_condicionado, :constancias, :soporte)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombrePaquete);
        $stmt->bindParam(':cupo', $cupo);
        $stmt->bindParam(':aire_condicionado', $aireAcondicionado);
        $stmt->bindParam(':constancias', $constancias);
        $stmt->bindParam(':soporte', $soporte);
        $stmt->execute();

        // Redireccionar o mostrar un mensaje de éxito
        $_SESSION['mensaje'] = 'Paquete registrado exitosamente.';
        header('Location: paquetes.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Paquetes</title>
</head>
<body>

<div class="w3-container w3-center w3-dark-grey" style="padding: 128px 16px">
    <h3>GESTIÓN DE PAQUETES</h3>
    <p class="w3-large">Agregar nuevos paquetes disponibles</p>
    <div class="w3-row-padding" style="margin-top: 64px">
        <div class="w3-third w3-section">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <ul class="w3-ul w3-white w3-hover-shadow">
                    <li class="w3-green-custom w3-xlarge w3-padding-32">Nuevo Paquete</li>
                    <li class="w3-padding-16">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </li>
                    <li class="w3-padding-16">
                        <label for="cupo">Cupo:</label>
                        <input type="number" id="cupo" name="cupo" required>
                    </li>
                    <li class="w3-padding-16">
                        <label for="aire_condicionado">Aire Acondicionado:</label>
                        <input type="number" id="aire_condicionado" name="aire_condicionado" required>
                    </li>
                    <li class="w3-padding-16">
                        <label for="constancias">Constancias:</label>
                        <input type="number" id="constancias" name="constancias" required>
                    </li>
                    <li class="w3-padding-16">
                        <label for="soporte">Soporte:</label>
                        <input type="text" id="soporte" name="soporte" required>
                    </li>
                    <li class="w3-light-grey w3-padding-24">
                        <button type="submit" class="w3-button w3-green-custom w3-padding-large">Guardar Paquete</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

</body>
</html>
