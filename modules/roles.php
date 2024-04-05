<?php include_once("../includes/header-admin.php"); ?>

<link rel="stylesheet" href="../assets/css/style-main.css"> 

<main>
    <h1>Lista de roles</h1>
    <a href="add-role.php" class="btn add-employee-btn">Añadir rol</a>
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
                                echo '<th>Id rol</th>';
                                echo '<th>Nombre</th>';
                                echo '<th>Nº de empleados</th>';
                                echo '<th>Descargar listado</th>';
                            echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';
                        // Iterar sobre los resultados y mostrar cada rol en una fila de la tabla
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                echo '<td>' . $row['id_rol'] . '</td>';
                                echo '<td>' . $row['nombre_rol'] . '</td>';
                                echo '<td>N/A</td>'; // Número de empleados asociados a cada rol (FALTA)
                                echo '<td>prueba</td>'; // (FALTA)
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
