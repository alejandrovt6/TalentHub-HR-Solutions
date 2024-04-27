<?php
    require_once '../includes/connection.php';
    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
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

        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            // Eliminar el rol
            $query = "DELETE FROM roles WHERE id_rol = '$id_rol'";
            $result = mysqli_query($db, $query);

            if($result) {
                // ALERTA
                header("Location: ../modules/roles.php");
                exit(); 
            }
        }

        // Información del rol
        $query = "SELECT * FROM roles WHERE id_rol = '$id_rol'";
        $result = mysqli_query($db, $query);
        $rol = mysqli_fetch_assoc($result);
    } else {
        header("Location: ../modules/roles.php");
        exit();
    }
?>

<?php include_once("../includes/header-admin.php"); ?>

<main>
    <h1>Eliminar Rol</h1>
    <div class="container">
        <p style="text-align: center;">¿Seguro que quieres eliminar el rol '<?php echo '<b>' . $rol['nombre_rol'] . '</b>'; ?>'?</p>
        <form action="delete-role.php?id_rol=<?php echo $id_rol; ?>" method="POST">
            <input type="hidden" name="confirm" value="yes">
            <button class="btn btn-delete" type="submit">Eliminar</button>
            <a href="../modules/roles.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</main>


<?php include_once("../includes/footer.php"); ?>
