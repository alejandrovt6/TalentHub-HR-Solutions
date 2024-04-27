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

    if(isset($_GET['dni'])) {
        $dni = $_GET['dni'];

        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            // Eliminar el empleado
            $query = "DELETE FROM empleados WHERE dni = '$dni'";
            $result = mysqli_query($db, $query);

            if($result) {
                // ALERTA
                header("Location: ../modules/employees.php");
                exit(); 
            } else {
                echo "Hubo un error al eliminar el empleado."; // ALERTA
            }
        }

        // Información del empleado
        $query = "SELECT * FROM empleados WHERE dni = '$dni'";
        $result = mysqli_query($db, $query);
        $empleado = mysqli_fetch_assoc($result);
    } else {
        header("Location: ../modules/employees.php");
        exit();
    }
?>

<?php include_once("../includes/header-admin.php"); ?>

<main>
    <h1>Eliminar Empleado</h1>
    <div class="container">
        <p style="text-align: center;">¿Seguro que quieres eliminar al empleado '<?php echo '<b>' . $empleado['nombre'] . ' ' . $empleado['apellidos'] . '</b>'; ?>'? </p>
        <form action="delete-employee.php?dni=<?php echo $dni; ?>" method="POST">
            <input type="hidden" name="confirm" value="yes">
            <button class="btn btn-delete" type="submit">Eliminar</button>
            <a href="../modules/employees.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>

