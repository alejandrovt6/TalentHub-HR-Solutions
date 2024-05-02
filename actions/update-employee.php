<?php
    session_start();
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Verificar si se recibieron datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir datos
        $dni = $_POST['dni'];

        // Actualizar datos del empleado
        $query = "UPDATE empleados SET nombre = ?, apellidos = ?, email = ?, fecha_inicio = ?, fecha_nacimiento = ?, id_rol = ?, sueldo = ? WHERE dni = ?";
        $stmt = mysqli_prepare($db, $query);

        // Verificar la preparación de la consulta
        if ($stmt) {
            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['fecha_inicio'], $_POST['fecha_nacimiento'], $_POST['id_rol'], $_POST['sueldo'], $dni);

            // Ejecutar consulta
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../modules/employees.php?success=1");
                exit();
            } else {
                echo "Error al actualizar los datos del empleado.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta.";
        }

        mysqli_close($db);
    } else {
        header("Location: ../index.php"); 
        exit();
    }
?>