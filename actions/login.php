<?php
require_once '../includes/connection.php';

// Recoger datos del form
if(isset($_POST['dni'], $_POST['contraseña'])) { 
    $dni = trim($_POST['dni']);
    $contraseña = $_POST['contraseña'];

    // Comprobar usuario
    $sql = "SELECT * FROM empleados WHERE dni = '$dni'";
    $login = mysqli_query($db, $sql);
    
    if($login && mysqli_num_rows($login) == 1) {
        $empleado = mysqli_fetch_assoc($login);
        // Verificar contraseña
        if (password_verify($contraseña, $empleado['contraseña'])) {
            session_start();
            $_SESSION['authenticated'] = true; // Indicar que el usuario está autenticado
            $_SESSION['dni'] = $empleado['dni'];
            $_SESSION['rol_id'] = $empleado['id_rol']; // Guardar el ID de rol en la sesión
            // Redirigir según el rol
            if ($empleado['id_rol'] == 1) {
                header("Location: ../modules/admin.php");
            } else {
                header("Location: ../modules/employee.php");
            }
            exit(); 
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
    
} else {
    echo "Datos del formulario no recibidos";
}
?>
