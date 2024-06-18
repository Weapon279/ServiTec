<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumno_id = $_POST['alumno_id'];
    $grupo_id = $_POST['grupo_id'];

    // Actualizar el estado del aspirante a aceptado
    $sql = "UPDATE alumnos SET Status = 1 WHERE id_Alumno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();

    // Asociar al alumno con el grupo
    $sql = "UPDATE grupo SET Fk_id_Alumno = ?, Status = 1 WHERE id_Grupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $alumno_id, $grupo_id);
    $stmt->execute();

    echo "Solicitud aceptada.";
}
?>
