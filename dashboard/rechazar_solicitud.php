<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumno_id = $_POST['alumno_id'];
    $grupo_id = $_POST['grupo_id'];

    // Actualizar el estado del aspirante a rechazado
    $sql = "UPDATE alumnos SET Status = 2 WHERE id_Alumno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();

    echo "Solicitud rechazada.";
}
?>
