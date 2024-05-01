<?php
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Obtener DNI
    $dni = $_SESSION['dni'];

    // Obtener información del empleado
    $query_empleado = "SELECT * FROM empleados WHERE dni = ?";
    $stmt_empleado = mysqli_prepare($db, $query_empleado);

    // Vincular parámetros
    mysqli_stmt_bind_param($stmt_empleado, "s", $dni);

    // Ejecutar consulta
    mysqli_stmt_execute($stmt_empleado);

    // Obtener el resultado
    $result_empleado = mysqli_stmt_get_result($stmt_empleado);

    // Verificar si se encontraron resultados
    if ($result_empleado && mysqli_num_rows($result_empleado) > 0) {
        $empleado = mysqli_fetch_assoc($result_empleado);
        $rol_id = $empleado['id_rol'];

        // Nombre del rol
        $query_rol = "SELECT nombre_rol FROM roles WHERE id_rol = ?";
        $stmt_rol = mysqli_prepare($db, $query_rol);

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt_rol, "i", $rol_id);

        // Ejecutar consulta
        mysqli_stmt_execute($stmt_rol);

        // Obtener resultado
        $result_rol = mysqli_stmt_get_result($stmt_rol);

        // Verificar si se encontraron resultados
        if ($result_rol && mysqli_num_rows($result_rol) > 0) {
            $roles = mysqli_fetch_assoc($result_rol);
        } else {
            echo "No se encontró el nombre del rol del empleado.";
            exit();
        }
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
            <div class="form-group">
                <label for="rol">Rol:</label>
                <input type="text" id="rol" name="rol" value="<?php echo $roles['nombre_rol']; ?>" readonly>    
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha inicio:</label>
                <input type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo $empleado['fecha_inicio']; ?>" readonly>    
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha nacimiento:</label>
                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $empleado['fecha_nacimiento']; ?>" readonly>    
            </div>
            <div class="form-group">
                <label for="sueldo">Sueldo:</label>
                <input type="text" id="sueldo" name="sueldo" value="<?php echo $empleado['sueldo']; ?>" readonly>    
            </div>
            <button class="btn add-employee-btn" type="submit">Guardar cambios</button>
        </form>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
