<?php
    require_once '../includes/connection.php';

    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated'] || $_SESSION['rol_id'] != 1) {
        header("Location: ../index.php");
        exit();
    }

    if (isset($_POST['id_rol']) && is_numeric($_POST['id_rol'])) {
        $id_rol = $_POST['id_rol'];
        $nombre_rol = $_POST['nombre_rol'];

        // Actualizar nombre del rol
        $query = "UPDATE roles SET nombre_rol = '$nombre_rol' WHERE id_rol = $id_rol";

        $result = mysqli_query($db, $query);

        if ($result) {
            header("Location: ../modules/roles.php");
            exit(); 
        } else {
            echo "Error al actualizar el rol.";
        }
    } else {
        echo "ID de rol inválido.";
    }
?>
