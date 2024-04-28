<?php

if(isset($_POST)) {

    require_once '../includes/connection.php';

    if(!isset($_SESSION)) {
      session_start();
    }

    // Traer datos del form y escapar datos
    $nombre_rol = isset($_POST['nombre_rol']) ? mysqli_real_escape_string($db, $_POST['nombre_rol']) : false;

    // Array de errores
    $errors = array();

    // Validar datos

    // Nombre rol
    if (!empty($nombre_rol)) {
        $nombre_rol_valido = true;
    } else {
        $nombre_rol_valido = false;
        $errors['nombre_rol'] = 'El nombre del rol es requerido.';
    }

    // Validar datos del formulario
    if (count($errors) == 0) {
        $sql = "INSERT INTO roles (id_rol, nombre_rol) VALUES (NULL, '$nombre_rol')";

        // Ejecutar la consulta SQL para insertar el rol
        $save = mysqli_query($db, $sql);

        // Verificar si se guardó correctamente el rol
        if ($save) {
            $_SESSION['completed'] = 'Rol registrado exitosamente!';
            header("Location: ../modules/roles.php");
            exit();
        } else {
            $_SESSION['errors']['general'] = 'Error al registrar el rol. Por favor, inténtalo de nuevo.';
        }
    } else {
        // Si hay errores de validación, guardarlos en la sesión
        $_SESSION['errors'] = $errors;
    }

}