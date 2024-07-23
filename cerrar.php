<?php
session_start();
require 'modelo/conexion.php';

// Verificar si el usuario está autenticado
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    try {
        // Eliminar la sesión del usuario en la base de datos
        $stmt = $conn->prepare("DELETE FROM sesion WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        // Destruir la sesión de PHP
        session_destroy();
    } catch (PDOException $e) {
        header("Location: error.php");
        exit();
    }
}

// Redirigir al formulario de inicio de sesión
header("Location: login.php");
exit();
?>
