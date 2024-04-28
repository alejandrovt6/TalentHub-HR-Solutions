<?php
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Verificar si se recibieron datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir datos del formulario
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        
        // Actualizar datos del empleado
        $query = "UPDATE empleados SET nombre = ?, apellidos = ?, email = ?";
        $params = array($nombre, $apellidos, $email);

        // Verificar si se proporcionó una nueva contraseña
        if (!empty($contraseña)) {
            // Encriptar la nueva contraseña
            $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT, ['cost' => 4]);
            // Agregar la contraseña encriptada a la consulta de actualización
            $query .= ", contraseña = ?";
            $params[] = $contraseña_encriptada;
        }

        $query .= " WHERE dni = ?";
        $params[] = $dni;

        // Preparar consulta
        $stmt = mysqli_prepare($db, $query);

        // Verificar la preparación de la consulta
        if ($stmt) {
            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);

            // Ejecutar consulta
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../modules/data.php?success=1");
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
