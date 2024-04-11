<?php
    require_once '../includes/connection.php';
    // Verificar si el empleado está autenticado
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: ../index.php"); // Si no está autenticado
        exit();
    }

    // Verificar si el usuario tiene el rol adecuado
    if ($_SESSION['rol_id'] != 1) {
        header("Location: ../index.php"); 
        exit();
    }
?>

<?php
    require_once '../includes/connection.php';

    $id_rol = isset($_GET['id_rol']) ? intval($_GET['id_rol']) : 0;

    if ($id_rol > 0) {
      $sql = "SELECT nombre_rol FROM roles WHERE id_rol = $id_rol";
      $result = mysqli_query($db, $sql);

      if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $nombre_rol = $row['nombre_rol'];
      } else {
        echo '<p>¡El rol no existe!</p>';
        exit;
      }
    } else {
      echo '<p>¡ID de rol inválido!</p>';
      exit;
    }
?>

<?php include_once("../includes/header-admin.php"); ?>

    <main>
        <h1>Editar rol</h1>
        <div class="container">
            <form action="./update-role.php" method="POST">
            <input type="hidden" name="id_rol" value="<?php echo $id_rol; ?>">
            <div class="form-group">
                <label for="nombre-rol">Nombre del rol:</label>
                <input type="text" id="nombre_rol" name="nombre_rol" value="<?php echo isset($nombre_rol) ? $nombre_rol : ''; ?>" required>
            </div>
            <button class="btn add-employee-btn" type="submit">Actualizar Rol</button>
            </form>
        </div>
    </main>

<?php include_once("../includes/footer.php"); ?>
