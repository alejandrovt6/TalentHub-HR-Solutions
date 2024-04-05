<?php include_once("../includes/header-admin.php"); ?>

<main>
    <h1>Añadir nuevo rol</h1>
    <div class="container">
        <form action="../actions/new-role.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre-rol">Nombre del rol:</label>
                <input type="text" id="nombre_rol" name="nombre_rol" required>
            </div>
            <button class="btn add-employee-btn" type="submit">Añadir Rol</button>
        </form>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>