<?php
if(isset($_POST)) {

    require_once '../includes/connection.php';

    if(!isset($_SESSION)) {
      session_start();
    }

    // Traer los datos del form y escapar datos
    $dni = isset($_POST['dni']) ? mysqli_real_escape_string($db, $_POST['dni']) : false;
    $contraseña = isset($_POST['contraseña']) ? mysqli_real_escape_string($db, $_POST['contraseña']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : false;
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $imagen = isset($_POST['imagen']) ? mysqli_real_escape_string($db, $_POST['imagen']) : false;
    $id_rol = isset($_POST['id_rol']) ? mysqli_real_escape_string($db, $_POST['id_rol']) : false;
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? mysqli_real_escape_string($db, $_POST['fecha_nacimiento']) : false; 
    $fecha_inicio = isset($_POST['fecha_inicio']) ? mysqli_real_escape_string($db, $_POST['fecha_inicio']) : false;
    $sueldo = isset($_POST['sueldo']) ? mysqli_real_escape_string($db, $_POST['sueldo']) : false;

    // Array de errores
    $errors = array();

    // Validar datos
    if (!empty($dni) && strlen($dni) == 9 && preg_match("/^[0-9]{8}[A-Za-z]$/", $dni)) {
        $dni_valido = true;
    } else {
        $dni_valido = false;
        $errors['dni'] = 'El DNI debe tener el formato correcto.';
    }

    if (!empty($contraseña) && strlen($contraseña) >= 8) {
        $contraseña_valido = true;
    } else {
        $contraseña_valido = false;
        $errors['contraseña'] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_valido = true;
    } else {
        $email_valido = false;
        $errors['email'] = 'El correo electrónico no es válido.';
    }

    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_valido = true;
    } else {
        $nombre_valido = false;
        $errors['nombre'] = 'El nombre no es válido.';
    }

    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidos_valido = true;
    } else {
        $apellidos_valido = false;
        $errors['apellidos'] = 'Los apellidos no son válidos.';
    }

    // Validar la imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener la información del archivo subido
        $imagen_name = $_FILES['imagen']['name']; // Nombre del archivo
        $imagen_tmp = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo en el servidor
        $imagen_size = $_FILES['imagen']['size']; // Tamaño del archivo en bytes
        $imagen_type = $_FILES['imagen']['type']; // Tipo MIME del archivo

        // Mover el archivo cargado a la ubicación deseada en el servidor
        $upload_directory = '../assets/img/profiles'; // Directorio donde se guardará la imagen
        $ruta_imagen = $upload_directory . $imagen_name; // Ruta completa donde se guardará la imagen

        // Mover el archivo temporal a la ubicación deseada
        if(move_uploaded_file($imagen_tmp, $ruta_imagen)) {
            // La imagen se ha subido correctamente
            $imagen_valido = true;
        } else {
            // Error al mover el archivo
            $errors['imagen'] = 'Error al subir la imagen.';
            $imagen_valido = false;
        }
    } else {
        // No se ha subido ningún archivo
        $errors['imagen'] = 'Por favor, selecciona una imagen.';
        $imagen_valido = false;
    }


    if (!empty($id_rol) && is_numeric($id_rol)) {
        $id_rol_valido = true;
    } else {
        $id_rol_valido = false;
        $errors['id_rol'] = 'El ID de rol no es válido.';
    }

    if (!empty($fecha_nacimiento) && strtotime($fecha_nacimiento)) {
        $fecha_nacimiento_valido = true;
    } else {
        $fecha_nacimiento_valido = false;
        $errors['fecha_nacimiento'] = 'La fecha de nacimiento no es válida.';
    }

    if (!empty($fecha_inicio) && strtotime($fecha_inicio)) {
        $fecha_inicio_valido = true;
    } else {
        $fecha_inicio_valido = false;
        $errors['fecha_inicio'] = 'La fecha de inicio no es válida.';
    }

    if (!empty($sueldo) && is_numeric($sueldo)) {
        $sueldo_valido = true;
    } else {
        $sueldo_valido = false;
        $errors['sueldo'] = 'El sueldo no es válido.';
    }

    // Verificar si se puede guardar el usuario
    $save_user = false;
    if (count($errors) == 0) {
        $save_user = true;
    }

    // Encriptar y verificar contraseña
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT, ['cost=>4']);

    // Validar datos del formulario y comprobar si hay errores
    if (count($errors) == 0) {
        // Consulta SQL
        $sql = "INSERT INTO empleados (dni, contraseña, email, nombre, apellidos, imagen, id_rol, fecha_nacimiento, fecha_inicio, sueldo) 
        VALUES ('$dni', '$contraseña_encriptada', '$email', '$nombre', '$apellidos', '$ruta_imagen', '$id_rol', '$fecha_nacimiento', '$fecha_inicio', '$sueldo')";

        $save = mysqli_query($db, $sql);

        // Verificar si se guardó el usuario
        if ($save) {
            $_SESSION['completed'] = '¡Empleado registrado exitosamente!';
            header("Location: ../modules/employees.php"); // Redirigirá cuando se cree el usuario
            exit();
        } else {
            $_SESSION['errors']['general'] = 'Error al registrar el empleado. Por favor, inténtalo de nuevo.';
        }
    } else {
        // Si hay errores de validación, se guardan en la sesión
        $_SESSION['errors'] = $errors;
    }
}

