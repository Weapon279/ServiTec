<?php
    session_start();
    $typeUser = $_SESSION['typeUsr'];

    if ($typeUser == 1){
        echo "Admin":
    }
    else if ($typeUser == 2){
        echo "Alumno"
    }
    else {
        echo "Otros"
    }

?>