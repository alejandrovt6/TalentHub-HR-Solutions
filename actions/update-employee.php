<?php
    if(isset($_POST)) {

        require_once '../includes/connection.php';

        if(!isset($_SESSION)) { // QUITAR
        session_start();
        }

        // Traer los datos del form y escapar datos
        $dni = isset($_POST['dni']) ? mysqli_real_escape_string($db, $_POST['dni']) : false;
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
            $imagen_name = $_FILES['imagen']['name']; 
            $imagen_tmp = $_FILES['imagen']['tmp_name']; 
            $imagen_size = $_FILES['imagen']['size']; 
            $imagen_type = $_FILES['imagen']['type']; 

            // Mover el archivo cargado a la ruta
            $upload_directory = '../assets/img/profiles/'; 
            $ruta_imagen = $upload_directory . $imagen_name; 

            // Mover el archivo temporal a la ruta
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

        // Actualizar datos del formulario y comprobar si hay errores
        if (count($errors) == 0) {
            // Consulta SQL
            $empleado = $_SESSION['empleado'];
            $sql = "UPDATE empleados SET " . 
                "dni = '$dni'," . 
                "email = '$email'" . 
                "nombre = '$nombre'," . 
                "apellidos = '$apellidos'," . 
                "imagen = '$imagen'," . 
                "id_rol = '$id_rol'," . 
                "fecha_nacimiento = '$fecha_nacimiento'," . 
                "fecha_inicio = '$fecha_inicio'," . 
                "sueldo = '$sueldo'," . 
                "WHERE dni = " . $empleado['dni'];

            $save = mysqli_query($db, $sql);

            // Verificar si se editó el usuario
            if ($save) {
                $_SESSION['empleado']['dni'] = $dni;
                $_SESSION['empleado']['email'] = $email;
                $_SESSION['empleado']['nombre'] = $nombre;
                $_SESSION['empleado']['apellidos'] = $apellidos;
                $_SESSION['empleado']['id_rol'] = $id_rol;
                $_SESSION['empleado']['fecha_nacimiento'] = $fecha_nacimiento;
                $_SESSION['empleado']['fecha_inicio'] = $fecha_inicio;
                $_SESSION['empleado']['sueldo'] = $sueldo;
                $_SESSION['completed'] = '¡Empleado editado exitosamente!';
                header("Location: ../modules/employees.php"); // Redirigirá cuando se edite el usuario
                exit();
            } else {
                $_SESSION['errors']['general'] = 'Error al editar el empleado. Por favor, inténtalo de nuevo.';
            }
        } else {
            // Si hay errores de validación, se guardan en la sesión
            $_SESSION['errors'] = $errors;
        }
    }

header('Location: ../modules/employees.php');
