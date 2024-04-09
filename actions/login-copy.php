<?php
require_once '../includes/connection.php';

// Recoger datos del form
if(isset($_POST['dni'], $_POST['contraseña'])) { 
    $dni = trim($_POST['dni']);
    $contraseña = $_POST['contraseña'];

    // Consulta para comprobar usuario
    $sql = "SELECT * FROM empleados WHERE DNI = '$dni'";
    $login = mysqli_query($db, $sql);
    
    if($login && mysqli_num_rows($login) == 1) {
        $empleado = mysqli_fetch_assoc($login);
        // Verificar la contraseña
        if (password_verify($contraseña, $empleado['contraseña'])) {
            session_start();
            $_SESSION['user_dni'] = $empleado['DNI']; // Guardar el DNI del empleado en la sesión
            header("Location: ../modules/admin.php"); 
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