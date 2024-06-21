<?php
include 'conexion.php';
include 'indexa.php';

session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Notificaciones</h1>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php
                $sql = "SELECT id_Notificacion, Tipo, Mensaje, FechaHora, Leida FROM notificaciones ORDER BY FechaHora DESC";
                $resultado = $conn->query($sql);

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

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
