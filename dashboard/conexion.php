<?php
$servername = "localhost";
$username = "Admin";
$password = "";
$dbname = "cursos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
