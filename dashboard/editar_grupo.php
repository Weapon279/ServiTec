<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_grupo = $_POST['id_grupo'];
    $claveGrupo = $_POST['claveGrupo'];
    $capacidad = $_POST['capacidad'];
    $fechaI = $_POST['fechaI'];
    $fechaF = $_POST['fechaF'];

    try {
        // Actualizar los datos del grupo
        $sql = "UPDATE grupo SET ClaveGrupo = ?, Capacidad = ?, FechaI = ?, FechaF = ? WHERE id_Grupo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $claveGrupo, $capacidad, $fechaI, $fechaF, $id_grupo);
        $stmt->execute();

        // Redireccionar a la página de grupos con un mensaje de éxito
        $_SESSION['message'] = 'Grupo actualizado exitosamente';
        header("Location: grupo.php");
        exit();
    } catch (Exception $e) {
        // Manejo de errores
        $_SESSION['error'] = 'Error al actualizar el grupo: ' . $e->getMessage();
        header("Location: grupo.php");
        exit();
    }
}
?>
