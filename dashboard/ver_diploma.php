<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_grupo = $_POST['id_grupo'];
    $nombreDiploma = $_POST['nombreDiploma'];
    $linkDiploma = $_POST['linkDiploma'];

    try {
        // Insertar el nuevo diploma en la base de datos
        $sql = "SELECT INTO diplomas (Fk_id_Grupo, NombreDiploma, LinkDiploma, FechaHoraC) VALUES (?, ?, ?,  NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_grupo, $nombreDiploma, $linkDiploma);
        $stmt->execute();

        // Redireccionar a la página de grupos con un mensaje de éxito
        $_SESSION['message'] = 'Diploma agregado exitosamente';
        header("Location: grupo.php");
        exit();
    } catch (Exception $e) {
        // Manejo de errores
        $_SESSION['error'] = 'Error al agregar el diploma: ' . $e->getMessage();
        header("Location: grupo.php");
        exit();
    }
}
?>
