<?php
include 'conexion.php';
include 'indexa.php';

// Suponiendo que $usuario_id está definido en 'indexa.php'
// Si no es así, asegúrate de obtener el ID del usuario de la manera apropiada
// Ejemplo: $usuario_id = $_SESSION['id_User'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['join_group'])) {
    $curso_id = $_POST['curso_id'];
    $grupo_id = $_POST['grupo_id'];

    $conn->begin_transaction();

    try {
        // Insertar el interés del aspirante en la tabla intereses con Status activo
        $sql = "INSERT INTO intereses (Fk_id_User, Fk_id_Curso, Fk_id_Grupo, Status, FechaHoraC) VALUES (?, ?, ?, 1, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuario_id, $curso_id, $grupo_id);
        $stmt->execute();

        // Enviar una notificación al administrador
        $mensaje = "Nuevo aspirante registrado para el curso ID: $usuario_id en el grupo ID: $grupo_id";
        $tipo = "registro_grupo";
        $noti_sql = "INSERT INTO notificaciones (Tipo, Mensaje) VALUES (?, ?)";
        $noti_stmt = $conn->prepare($noti_sql);
        $noti_stmt->bind_param("ss", $tipo, $mensaje);
        $noti_stmt->execute();

        $conn->commit();
        // Marcamos que se debe mostrar el modal
        $mostrarModal = true;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al registrar el interés: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Aspirantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
/* Estilo para el modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
<body>
    <!-- Margen de tabla y menu lateral -->
<div class="w3-main" style="margin-left:320px;margin-top:60px;">
<!--Fin de margen -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Registro de Aspirantes</h1>
    <table class="table mt-5">
        <thead>
            <tr>
                <th>Nombre Curso</th>
                <th>Objectivo Curso</th>
                <th>Modalidad</th>
                <th>Descripción Curso</th>
                <th>Costo Curso</th>
                <th>Fecha Inicio Grupo</th>
                <th>Fecha Fin Grupo</th>
                <th>Capacidad del Grupo</th>
                <th>Costo del Grupo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT c.id_Curso, g.id_Grupo, c.NombreCurso, c.ObjectivoCurso, c.Modalidad, c.DescripcionCurso, c.CostoCurso, 
                        g.FechaI, g.FechaF, g.Capacidad, g.Costo
                    FROM curso c
                    JOIN grupo g ON c.id_Curso = g.Fk_id_Curso
                    WHERE c.Status IN ('Disponible', 'Falta Informacion')";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['NombreCurso']}</td>
                        <td>{$row['ObjectivoCurso']}</td>
                        <td>{$row['Modalidad']}</td>
                        <td>{$row['DescripcionCurso']}</td>
                        <td>{$row['CostoCurso']}</td>
                        <td>{$row['FechaI']}</td>
                        <td>{$row['FechaF']}</td>
                        <td>{$row['Capacidad']}</td>
                        <td>{$row['Costo']}</td>
                        <td>
                            <form method='POST' action='registroc.php'>
                                <input type='hidden' name='curso_id' value='{$row['id_Curso']}'>
                                <input type='hidden' name='grupo_id' value='{$row['id_Grupo']}'>
                                <button type='submit' name='join_group' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modal'>Unirse al Grupo</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>

        </tbody>
    </table>
</div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Usuario registrado con éxito. Inicia sesión</p>
        </div>
    </div>

    <script>
        // Script para cerrar el modal y redirigir después de 2 segundos
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modal');
            var span = document.getElementsByClassName('close')[0];

            if (modal.style.display == 'block') {
                setTimeout(function() {
                    modal.style.display = 'none';
                    window.location.href = 'login.php';
                }, 10000);
            }

            // Cuando el usuario hace clic en <span> (x), cierra el modal
            span.onclick = function() {
                modal.style.display = 'none';
            }

            // Cuando el usuario hace clic fuera del modal, lo cierra
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>

</body>
</html>
