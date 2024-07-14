<?php
include 'conexion.php';

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $sql = "SELECT id_User, vNombre, vApellidoP, vApellidoM, vCorreo, nWhats, nPass  FROM user WHERE id_User = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'ID de usuario no especificado']);
}
?>
