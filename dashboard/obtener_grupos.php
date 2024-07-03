<?php
include 'conexion.php';

if (isset($_GET['curso_id'])) {
    $curso_id = $_GET['curso_id'];

    $sql = "SELECT id_Grupo, ClaveGrupo FROM grupo WHERE Fk_id_Curso = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $grupos = [];
    while ($row = $result->fetch_assoc()) {
        $grupos[] = $row;
    }

    echo json_encode($grupos);
}
?>
