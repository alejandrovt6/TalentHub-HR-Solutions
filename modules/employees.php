<?php include_once("../includes/header-admin.php"); ?>

<link rel="stylesheet" href="../assets/css/style-main.css"> 

<main>
    <h1>Lista de empleados</h1>
    <div class="container">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha inicio</th>
                    <th>Sueldo</th>
                    <th>Informe</th>
                    <th>Administrar</th> <!-- EDITAR Y ELIMINAR -->
                </tr>
            </thead>
                <tr>
                    <td>prueba</td>
                    <td>12345678A</td>
                    <td>Antonio</td>
                    <td>Gutierrez Marmol</td>
                    <td>antoniogm@company.com</td>
                    <td>RRHH</td>
                    <td>01/04/2023</td>
                    <td>1500€</td>
                    <td>Descargar</td>
                    <td>Editar - Eliminar</td>
                </tr>
                <tr>
                    <td>prueba</td>
                    <td>87654321Z</td>
                    <td>Sara</td>
                    <td>Pérez Gómez</td>
                    <td>sarapg@company.com</td>
                    <td>Técnico</td>
                    <td>01/02/2024</td>
                    <td>1300€</td>
                    <td>Descargar</td>
                    <td>Editar - Eliminar</td>
                </tr>
        </table>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>
