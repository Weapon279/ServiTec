<?php
require 'conexion.php';
 
// Verificar si hay una sesión activa en la base de datos
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $sessionId = session_id();

    try {
        $stmt = "SELECT session_id FROM sesion WHERE user_id = :userId AND session_id = :sessionId";
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            // Si no hay una sesión activa válida, cerrar sesión
            header("Location: logout.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        die();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
