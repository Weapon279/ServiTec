<?php
require 'conexion.php';

$sql = "SELECT id_Curso, FechaHoraC FROM curso WHERE Status = 'Disponible'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $courseId = $row['id_Curso'];
    $fechaInicio = $row['FechaHoraC'];

    $today = new DateTime();
    $startDate = new DateTime($fechaInicio);
    $interval = $today->diff($startDate)->days;

    if ($interval <= 1) {
        $registeredStudentsSql = "SELECT COUNT(*) AS total FROM grupo WHERE Fk_id_Curso = $courseId";
        $registeredStudentsResult = $conn->query($registeredStudentsSql);
        $registeredStudents = $registeredStudentsResult->fetch_assoc()['total'];

        if ($registeredStudents < 10) {
            $updateSql = "UPDATE curso SET Status = 'Suspender' WHERE id_Curso = $courseId";
            $conn->query($updateSql);
        }
    }
}
$conn->close();
?>
