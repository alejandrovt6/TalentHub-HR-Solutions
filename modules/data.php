<?php
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Obtener el DNI del empleado autenticado
    $dni = $_SESSION['dni'];

    // Obtener la información del empleado
    $query = "SELECT * FROM empleados WHERE dni = ?";
    $stmt = mysqli_prepare($db, $query);

    // Vincular parámetros
    mysqli_stmt_bind_param($stmt, "s", $dni);

    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);

    // Obtener el resultado
    $result = mysqli_stmt_get_result($stmt);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $empleado = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontró la información del empleado.";
        exit();
    }

    // Determinar qué archivo de encabezado incluir según el rol del empleado
    $header = ($empleado['id_rol'] == 1) ? "header-admin.php" : "header-employee.php";
?>

<?php include_once("../includes/$header");?>


<main class="main">
    <h1>Mis datos</h1>
    <a href="../actions/edit-data.php" class="btn btn-edit-data">Editar mis datos</a>
    <div class="container">
        <form action="update-data.php" method="post">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?php echo $empleado['dni']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $empleado['nombre']; ?>" readonly>    
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $empleado['apellidos']; ?>" readonly>    
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $empleado['email']; ?>" readonly>    
            </div>


            <!--TODO: OTROS CAMPOS -->

            <button class="btn add-employee-btn" type="submit">Guardar cambios</button>
        </form>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
