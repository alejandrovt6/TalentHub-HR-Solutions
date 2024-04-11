<?php
    require_once '../includes/connection.php';
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); // Si no está autenticado
        exit();
    }

    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol_id'] != 1) {
        header("Location: ../index.php"); // Si no tiene el rol adecuado
        exit();
    }
?>

<?php include_once("../includes/header-admin.php"); ?>

<main>
    <h1>Añadir nuevo empleado</h1>
    <div class="container">
        <form action="../actions/new-employee.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="id_rol">Rol:</label>
                <select id="id_rol" name="id_rol" required> 
                    <?php
                        // require_once '../includes/connection.php';

                        // Roles disponibles
                        $query = "SELECT id_rol, nombre_rol FROM roles";
                        $result = mysqli_query($db, $query);

                        // Verificar si hay resultados e iterar
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
                <label for="edad">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="sueldo">Sueldo:</label>
                <input type="number" id="sueldo" name="sueldo" required>
            </div>
            <button class="btn add-employee-btn" type="submit">Añadir Empleado</button>
        </form>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
