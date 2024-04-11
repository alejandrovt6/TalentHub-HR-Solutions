<?php
    require_once '../includes/connection.php';

    if(isset($_POST['dni'])) {
        $dni = $_POST['dni'];

        // Eliminar el empleado
        $query = "DELETE FROM empleados WHERE dni = '$dni'";

        $result = mysqli_query($db, $query);

        if($result) {
            echo "Empleado eliminado correctamente.";
        } else {
            echo "Hubo un error al eliminar el empleado.";
        }
    } 
?>
