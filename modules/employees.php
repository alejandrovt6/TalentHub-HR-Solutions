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

<?php include_once("../includes/header-admin.php"); ?>

<link rel="stylesheet" href="../assets/css/style-main.css"> 

<main class="main-employees">
    <h1>Lista de empleados</h1>
    <a href="add-employee.php" class="btn add-employee-btn">Añadir empleado</a>
    <div class="container">
        <table class="employee-table">

            <?php
                require_once '../includes/connection.php';

            // Consulta SQL
            $sql = "SELECT * FROM empleados";
            $result = mysqli_query($db, $sql);

            // Verificar si se encontraron empleados
            if ($result && mysqli_num_rows($result) > 0) {
                // Iniciar la sección de la tabla
                echo '<table class="employee-table">';
                    echo '<thead>';
                        echo '<tr>';
                            echo '<th>Imagen</th>';
                            echo '<th>DNI</th>';
                            echo '<th>Nombre</th>';
                            echo '<th>Apellidos</th>';
                            echo '<th>Email</th>';
                            echo '<th>Rol</th>';
                            echo '<th>Fecha inicio</th>';
                            echo '<th>Sueldo</th>';
                            echo '<th>Informe</th>';
                            echo '<th colspan="2">Administrar</th>';
                            // echo '<th>Eliminar</th>';
                        echo '</tr>';
                    echo '</thead>';
                echo '<tbody>';

                // Iterar sobre los resultados y mostrar empleados
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                        echo '<td><img src="' . $row['imagen'] . '" alt="Img"></td>';
                        echo '<td>' . $row['dni'] . '</td>';
                        echo '<td>' . $row['nombre'] . '</td>';
                        echo '<td>' . $row['apellidos'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';

                        // Obtener nombre del rol
                        $rol_id = $row['id_rol'];
                        $rol_query = "SELECT nombre_rol FROM roles WHERE id_rol = $rol_id";
                        $rol_result = mysqli_query($db, $rol_query);
                        $rol_nombre = mysqli_fetch_assoc($rol_result)['nombre_rol'];

                        echo '<td>' . $rol_nombre . '</td>';
                        echo '<td>' . $row['fecha_inicio'] . '</td>';
                        echo '<td>' . number_format($row['sueldo'], 0, ',','.') . '</td>';
                        echo '<td><a href="#" class="btn-table btn-download">Descargar</a></td>';
                        echo '<td><a href="../actions/edit-employee.php?dni=' . $row['dni'] . '" class="btn-table btn-edit">Editar</a></td>';
                        echo '<td><a href="../actions/delete-employee.php?dni=' . $row['dni'] . '" class="btn-table btn-delete">Eliminar</a></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No se encontraron empleados.';
            }
            ?>

        </table>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
