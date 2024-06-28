<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumno_id = $_POST['alumno_id'];

    // Actualizar el estado del aspirante a rechazado
    $sql = "UPDATE alumnos SET Status = 0 WHERE id_Alumno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();

    if ($stmt->execute()) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('modal').style.display = 'block';
                    setTimeout(function() {
                        window.location.href = 'grupo.php';
                    }, 2000);
                });
              </script>";

    echo "";
}
}
?>
<style>
        body, html {
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .bg-img {
            background-image: url("../recursos/img/img13.jpg");
            min-height: 700px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }

        .container {
            position: absolute;
            right: 0;
            margin: 20px;
            max-width: 300px;
            padding: 16px;
            background-color: white;
        }

        input[type=text], input[type=password], input[type=number] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .btn:hover {
            opacity: 1;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
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
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Solicitud Rechazada.</p>
  </div>
</div>

<script>
    // Script para cerrar el modal y redirigir después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modal');
        var span = document.getElementsByClassName('close')[0];

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