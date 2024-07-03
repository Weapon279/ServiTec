<?php
include 'conexion.php';
include 'indexa.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $curso_id = $_POST['curso_id'];
    $grupo_id = $_POST['grupo_id'];
    $usuario_id = $_SESSION['id_User'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar el interés del aspirante en la tabla intereses
        $sql = "INSERT INTO intereses (Fk_id_User, Fk_id_Curso, Fk_id_Grupo, Status, FechaHoraC) VALUES (?, ?, ?, 1, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuario_id, $curso_id, $grupo_id);
        $stmt->execute();

        // Insertar al usuario en el grupo con estado activo en la tabla alumnos
        $sql_alumno = "INSERT INTO alumnos (Fk_id_User, Fk_Id_Grupo, Status, FechaHoraC) VALUES (?, ?, 1, NOW())";
        $stmt_alumno = $conn->prepare($sql_alumno);
        $stmt_alumno->bind_param("ii", $usuario_id, $grupo_id);
        $stmt_alumno->execute();

        // Confirmar la transacción
        $conn->commit();

        echo "Interés registrado con éxito";
        header("Location: registroc.php");
        exit();
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo "Error al registrar el interés: " . $e->getMessage();
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
                    <option value="">Seleccione un curso</option>
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
                    <option value="">Seleccione un grupo</option>
                    <!-- Los grupos se llenarán dinámicamente usando JavaScript -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Interés</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('curso_id').addEventListener('change', function() {
    var cursoId = this.value;
    var grupoSelect = document.getElementById('grupo_id');
    grupoSelect.innerHTML = '<option value="">Seleccione un grupo</option>'; // Limpiar las opciones previas

    if (cursoId) {
        fetch('obtener_grupos.php?curso_id=' + cursoId)
            .then(response => response.json())
            .then(data => {
                data.forEach(grupo => {
                    var option = document.createElement('option');
                    option.value = grupo.id_Grupo;
                    option.textContent = grupo.ClaveGrupo;
                    grupoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al obtener los grupos:', error));
    }
});
</script>
</body>
</html>
