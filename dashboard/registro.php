<?php
include 'conexion.php';
session_start();

// Tu código de registro en grupo aquí

// Generar notificación para el administrador
$mensaje = "Nuevo aspirante registrado en grupo: {clave del grupo}";
$tipo = "registro_grupo";

$sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $tipo, $mensaje);
$stmt->execute();
?>
