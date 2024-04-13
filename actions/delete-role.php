<?php
    require_once '../includes/connection.php';
    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); // Si no está autenticado
        exit();
    }

    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol_id'] != 1) {
        header("Location: ../index.php"); 
        exit();
    }
?>

<?php
    require_once '../includes/connection.php';

    if(isset($_GET['id_rol'])) {
        $id_rol = $_GET['id_rol'];

        // Eliminar el rol
        $query = "DELETE FROM roles WHERE id_rol = '$id_rol'";

        $result = mysqli_query($db, $query);

        if($result) {
            // ALERTA
            header("Location: ../modules/roles.php");
            exit(); 
        } else {
            // ALERTA
        }
    } 
?>