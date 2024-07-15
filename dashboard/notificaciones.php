<?php
include 'conexion.php';
include 'indexa.php';

// Suponiendo que el ID del usuario está en la sesión
$usuarioId = $_SESSION['userId'] ?? null;

if (!$usuarioId) {
    echo "No has iniciado sesión.";
    exit;
}

// Consulta para verificar si el usuario es un administrador
$sqlUserType = "SELECT Fk_TypeUser FROM user WHERE id_User = ?";
$stmt = $conn->prepare($sqlUserType);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$resultUserType = $stmt->get_result();

if ($resultUserType->num_rows === 0) {
    echo "Usuario no encontrado.";
    exit;
}

$user = $resultUserType->fetch_assoc();
$typeUserId = $user['Fk_TypeUser'];

// Solo obtener notificaciones si el usuario es administrador (id_TypeUser = 3)
if ($typeUserId == 3) {
    $sql = "SELECT id_Notificacion, Tipo, Mensaje, FechaHora, Leida FROM notificaciones ORDER BY FechaHora DESC";
    $resultado = $conn->query($sql);

    echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Notificaciones</h1>';
    echo '<div class="row">';
    echo '<div class="col-md-8 offset-md-2">';

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $leida = $row['Leida'] ? "text-muted" : "";
            echo "<div class='card mb-3'>
                    <div class='card-body {$leida}'>
                        <h5 class='card-title'>{$row['Tipo']}</h5>
                        <p class='card-text'>{$row['Mensaje']}</p>
                        <p class='card-text'><small class='text-muted'>{$row['FechaHora']}</small></p>
                    </div>
                </div>";
        }
    } else {
        echo "<p class='text-center'>No hay notificaciones.</p>";
    }

    // Marcar las notificaciones como leídas
    $marcarLeidasSql = "UPDATE notificaciones SET Leida = 1 WHERE Leida = 0";
    $conn->query($marcarLeidasSql);

    echo '</div></div></div>';
} else {
    echo "<div class='container mt-5'><h1 class='text-center mb-4'>No cuentas con notificaciones</h1></div>";
}

$conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
