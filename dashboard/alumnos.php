<?php 
include 'conexion.php'; 
include 'indexa.php'; 

// Procesar la actualización del usuario si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $vNombre = $_POST['vNombre'];
    $vApellidoP = $_POST['vApellidoP'];
    $vApellidoM = $_POST['vApellidoM'];
    $vCorreo = $_POST['vCorreo'];
    $nWhats = $_POST['nWhats'];
    $nPass = password_hash($_POST['nPass'], PASSWORD_DEFAULT);

    // Actualizar la información del usuario
    $sql = "UPDATE user 
            SET vNombre = ?, vApellidoP = ?, vApellidoM = ?, vCorreo = ?, nWhats = ?, nPass = ?, iFechaHoraA = NOW()
            WHERE id_User = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', $vNombre, $vApellidoP, $vApellidoM, $vCorreo, $nWhats, $nPass, $userId);
    $stmt->execute();

    header('Location: alumnos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="w3-main" style="margin-left: 300px; margin-top: 43px;">

<div class="container mt-5">
    <h2>Usuarios</h2>
    <form method="GET" action="" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar usuario" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" oninput="clearSearchIfEmpty(this)">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre del Usuario</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>WhatsApp</th>
                <th>Curso Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Configuración para paginación
            $results_per_page = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start_limit = ($page - 1) * $results_per_page;

            // Obtener término de búsqueda
            $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';

            // Consulta SQL con búsqueda y paginación
            $sql = "SELECT  user.id_User, user.vNombre, user.vApellidoP, user.vApellidoM, user.vCorreo, user.nWhats, curso.NombreCurso 
                    FROM user 
                    LEFT JOIN alumnos ON user.id_User = alumnos.Fk_id_User 
                    LEFT JOIN grupo ON alumnos.id_Alumno = grupo.Fk_id_Alumno 
                    LEFT JOIN curso ON grupo.Fk_id_Curso = curso.id_Curso 
                    WHERE user.vNombre LIKE ? OR user.vApellidoP LIKE ? OR user.vApellidoM LIKE ? OR user.vCorreo LIKE ? 
                    ORDER BY user.vNombre ASC 
                    LIMIT ?, ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssii', $search, $search, $search, $search, $start_limit, $results_per_page);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['vNombre'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['vApellidoP'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['vApellidoM'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['vCorreo'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['nWhats'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['NombreCurso'] ?? ''); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editUser(<?php echo $row['id_User']; ?>)">Editar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <?php
    $sql_count = "SELECT COUNT(*) AS total FROM user WHERE user.vNombre LIKE ? OR user.vApellidoP LIKE ? OR user.vApellidoM LIKE ? OR user.vCorreo LIKE ?";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param('ssss', $search, $search, $search, $search);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $total_pages = ceil($row_count['total'] / $results_per_page);

    echo "<nav aria-label='Page navigation example'>
            <ul class='pagination justify-content-center'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='?page={$i}&search=" . urlencode(isset($_GET['search']) ? $_GET['search'] : '') . "'>{$i}</a></li>";
    }
    echo "</ul></nav>";
    ?>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="userId" id="editUserId">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="vNombre" id="editUserName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserLastName" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" name="vApellidoP" id="editUserLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserLastNameM" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" name="vApellidoM" id="editUserLastNameM" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserEmail" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="vCorreo" id="editUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserWhatsApp" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" name="nWhats" id="editUserWhatsApp" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserPass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="editUserPass" name="nPass" placeholder="Escribe tu contraseña" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editUser(userId) {
        // Lógica para obtener los datos del usuario y rellenar el formulario
        fetch('getuser.php?userId=' + userId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('editUserId').value = data.id_User;
                document.getElementById('editUserName').value = data.vNombre;
                document.getElementById('editUserLastName').value = data.vApellidoP;
                document.getElementById('editUserLastNameM').value = data.vApellidoM;
                document.getElementById('editUserEmail').value = data.vCorreo;
                document.getElementById('editUserWhatsApp').value = data.nWhats;
                document.getElementById('editUserPass').value = data.nPass;
                var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editUserModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function clearSearchIfEmpty(input) {
        if (input.value === '') {
            window.location.href = 'alumnos.php';
        }
    }
</script>
</body>
</html>
