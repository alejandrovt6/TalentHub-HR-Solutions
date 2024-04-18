<?php
    require_once '../includes/connection.php';

    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); 
        exit();
    }

    // Verificar el rol del usuario
    $header = ($_SESSION['rol_id'] == 1) ? "header-admin.php" : "header-employee.php";
?>
<?php include_once("../includes/$header"); ?> 

<main class="main">
    <h1>Mis datos</h1>
    <a href="edit-data.php" class="btn btn-edit-data">Editar mis datos</a>
    <div class="container">

    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
