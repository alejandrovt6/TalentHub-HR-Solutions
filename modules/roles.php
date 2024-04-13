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

<main>
    <h1>Lista de roles</h1>
    <a href="add-role.php" class="btn add-employee-btn">Añadir rol</a>

<div id="notification" class="notification">
<span id="notification-message"></span>
</div>

    <div class="container">

        <table class="role-table">
            <?php
                require_once '../includes/connection.php';

                // Consulta SQL para obtener los roles
                $sql = "SELECT id_rol, nombre_rol FROM roles";
                $result = mysqli_query($db, $sql);

                // Roles
                if ($result && mysqli_num_rows($result) > 0) {

                    echo '<table class="role-table">';

                        echo '<thead>';
                            echo '<tr>';
                                // echo '<th>Id rol</th>';
                                echo '<th>Nombre</th>';
                                echo '<th>Nº de empleados</th>';
                                echo '<th>Descargar listado</th>';
                                echo '<th colspan="2">Administrar</th>';

                            echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';
                        // Iterar sobre los resultados y mostrar cada rol en una fila de la tabla
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Consulta SQL para contar el número de empleados asociados a este rol
                            $rol_id = $row['id_rol'];
                            $count_query = "SELECT COUNT(*) AS count FROM empleados WHERE id_rol = $rol_id";
                            $count_result = mysqli_query($db, $count_query);

                            if ($count_result && mysqli_num_rows($count_result) > 0) {
                                $count_row = mysqli_fetch_assoc($count_result);
                                $num_empleados = $count_row['count'];
                            } else {
                                $num_empleados = 0;
                            }

                            echo '<tr>';
                                // echo '<td>' . $row['id_rol'] . '</td>';
                                echo '<td>' . $row['nombre_rol'] . '</td>';
                                echo '<td>' . $num_empleados . '</td>'; 
                                echo '<td><a href="#" class="btn-table btn-download">Descargar</a></td>';
                                echo '<td><a href="../actions/edit-role.php?id_rol=' . $row['id_rol'] . '" class="btn-table btn-edit">Editar</a></td>';
                                echo '<td><a href="../actions/delete-role.php?id_rol=' . $row['id_rol'] . '" class="btn-table btn-delete">Eliminar</a></td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        
                    echo '</table>';
                } else {
                    echo 'No se encontraron roles.';
                }
            ?>

        </table>
    </div>
</main>


<?php include_once("../includes/footer.php"); ?>
