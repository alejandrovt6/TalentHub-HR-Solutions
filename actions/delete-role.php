<?php
    require_once '../includes/connection.php';

    if(isset($_POST['id_rol'])) {
        $id_rol = $_POST['id_rol'];

        // Eliminar el rol
        $query = "DELETE FROM roles WHERE id_rol = '$id_rol'";

        $result = mysqli_query($db, $query);

        if($result) {
            echo "Rol eliminado correctamente.";
        } else {
            echo "Hubo un error al eliminar el rol.";
        }
    } 
?>