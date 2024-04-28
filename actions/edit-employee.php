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

    if (isset($_GET['dni'])) {
        $dni = $_GET['dni'];

        // Obtener información del empleado con el DNI
        $query = "SELECT * FROM empleados WHERE dni = '$dni'";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $employee = mysqli_fetch_assoc($result);

            // Obtener DNI
            $dni_empleado = isset($_GET['dni']) ? $_GET['dni'] : null;

            // Obtener datos
            $query = "SELECT * FROM empleados WHERE dni = '$dni_empleado'";
            $result = mysqli_query($db, $query);

            // Verificar si se encontró el empleado
            if ($result && mysqli_num_rows($result) > 0) {
                // Obtener los datos del empleado
                $empleado = mysqli_fetch_assoc($result);

                $dni = $empleado['dni'];
                $email = $empleado['email'];
                $nombre = $empleado['nombre'];
                $apellidos = $empleado['apellidos'];
                $id_rol = $empleado['id_rol']; 
                $imagen = isset($empleado['imagen']) ? $empleado['imagen'] : ''; 
                $fecha_nacimiento = $empleado['fecha_nacimiento'];
                $fecha_inicio = $empleado['fecha_inicio'];
                $sueldo = $empleado['sueldo'];
            } 
        }
    }
?>

<?php  require_once '../includes/connection.php'; ?>

<?php include_once "../includes/header-admin.php"; ?>

    <main>
        <h1>Editar empleado</h1>
        <div class="container">
        <form action="./new-employee.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $apellidos; ?>" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>
            <div class="form-group">
                <label for="id_rol">Rol:</label>
                <select id="id_rol" name="id_rol" value="<?php echo $id_rol; ?>" required> 
                    <?php
                        require_once '../includes/connection.php'; // ????

                        $query = "SELECT id_rol, nombre_rol FROM roles";
                        $result = mysqli_query($db, $query);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['id_rol']}\">{$row['nombre_rol']}</option>";
                            }
                        } else {
                            echo "<option value=\"\">No hay roles disponibles</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $empleado['fecha_nacimiento']; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $empleado['fecha_inicio']; ?>" required>
            </div>
            <div class="form-group">
                <label for="sueldo">Sueldo:</label>
                <input type="text" id="sueldo" name="sueldo" value="<?php echo number_format($empleado['sueldo'], 0, ',', '.'); ?>" required>
            </div>
            <button class="btn add-employee-btn" type="submit">Editar empleado</button>   
        </form>
        </div>
    </main>

<?php include_once("../includes/footer.php"); ?>