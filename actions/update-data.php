<?php
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Verificar si se recibieron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir los datos del formulario
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        
        
        $query = "UPDATE empleados SET nombre = ?, apellidos = ?, email = ? WHERE dni = ?";
        $stmt = mysqli_prepare($db, $query);

        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellidos, $email, $dni);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Redirigir al empleado de vuelta a la página de datos con un mensaje de éxito
            header("Location: ../modules/data.php?success=1");
            exit();
        } else {
            echo "Error al actualizar los datos del empleado.";
        }

        // Cerrar la declaración y la conexión
        mysqli_stmt_close($stmt);
        mysqli_close($db);
    } else {
        // Si se intenta acceder a este script sin enviar datos a través del formulario, redirigir a la página de inicio
        header("Location: ../index.php"); 
        exit();
    }
?>