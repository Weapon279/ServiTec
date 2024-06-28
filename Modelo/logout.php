<?php
session_start();
require 'conexion.php';

// Eliminar la sesión activa de la base de datos
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $stmt = $conn->prepare("DELETE FROM sesion WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}

session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
