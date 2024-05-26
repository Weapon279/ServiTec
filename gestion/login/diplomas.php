<?php include 'conexion.php'; ?>
<?php include 'index.php'; ?>

<div class="container mt-5">
    <h2>Gestión de Diplomas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Diploma</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT NombreDiploma, LinkDiploma FROM diplomas";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['NombreDiploma']}</td>
                        <td><a href='{$row['LinkDiploma']}' target='_blank'>Ver Diploma</a></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
