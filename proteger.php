<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['typeuser'])) {
    header("Location: login.php");
    exit();
}

// Verificar el tipo de usuario
$typeuser = $_SESSION['typeuser'];
?>
