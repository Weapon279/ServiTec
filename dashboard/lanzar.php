<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCurso = $_POST['id_Curso'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    $sql = "UPDATE curso SET FechaHoraC = ?, FechaHoraA = ?, Status = 'Disponible' WHERE id_Curso = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $fechaInicio, $fechaFin, $idCurso);

    if ($stmt->execute()) {
        header("Location: cursos.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
