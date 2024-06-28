<?php
include 'conexion.php';
include 'indexa.php';
include '../modelo/sesion.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $curso_id = $_POST['curso_id'];
    $grupo_id = $_POST['grupo_id'];
    $usuario_id = $_SESSION['id_User'];

    // Insertar el interés del aspirante en la tabla intereses
    $sql = "INSERT INTO intereses (Fk_id_User, Fk_id_Curso, Fk_id_Grupo, Status, FechaHoraC) VALUES (?, ?, ?, 0, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $usuario_id, $curso_id, $grupo_id);
    if ($stmt->execute()) {
        // Insertar al usuario en el grupo con estado activo
        $sql_group = "INSERT INTO alumnos (Fk_id_User, Fk_Id_Grupo, Status) VALUES (?, ?, 1)";
        $stmt_group = $conn->prepare($sql_group);
        $stmt_group->bind_param("ii", $usuario_id, $grupo_id);
        $stmt_group->execute();

        // Enviar una notificación al administrador
        $mensaje = "Nuevo aspirante registrado para el curso ID: $curso_id en el grupo ID: $grupo_id";
        $tipo = "registro_grupo";

        $noti_sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (?, ?)";
        $noti_stmt = $conn->prepare($noti_sql);
        $noti_stmt->bind_param("ss", $tipo, $mensaje);
        $noti_stmt->execute();

        echo "Interés registrado con éxito";
        header("Location: registroc.php");
        exit();
    } else {
        echo "Error al registrar el interés";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Aspirantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
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
            <div class="mb-3">
                <label for="grupo_id" class="form-label">Seleccione el Grupo</label>
                <select id="grupo_id" name="grupo_id" class="form-select" required>
                    <?php
                    $sql = "SELECT id_Grupo, ClaveGrupo FROM grupo";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_Grupo']}'>{$row['ClaveGrupo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Interés</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
