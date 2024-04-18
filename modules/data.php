<?php
    require_once '../includes/connection.php';
    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php");
        exit();
    }
?>

<?php include_once("../includes/header-admin.php"); ?>


<main class="main-employees">
        <h1>Mis datos</h1>
        <a href="edit-data.php" class="btn btn-edit-data">Editar mis datos</a>
        <div class="container">
            <table class="employee-table">



            </table>
        </div>
    </main>

<?php include_once("../includes/footer.php"); ?>

