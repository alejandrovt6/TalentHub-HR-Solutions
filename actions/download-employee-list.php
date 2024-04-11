<?php
require_once '../includes/connection.php';

if (isset($_GET['id_rol'])) {
    $rol_id = $_GET['id_rol'];

    // Consulta SQL para obtener los detalles de los empleados asociados a este rol
    $query = "SELECT * FROM empleados WHERE id_rol = $rol_id";
    $result = mysqli_query($db, $query);

    // Crear el archivo CSV o PDF y escribir los detalles de los empleados
    if ($result && mysqli_num_rows($result) > 0) {
        if ($_GET['format'] === 'csv') {
            // Código para generar CSV
        } else if ($_GET['format'] === 'pdf') {
            require_once('tcpdf/tcpdf.php');

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Agregar una página
            $pdf->AddPage();

            // Escribe el contenido del PDF aquí, puedes usar los datos de $result para generar el contenido
            // Por ejemplo:
            $content = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $content .= $row['DNI'] . ', ' . $row['nombre'] . ', ' . $row['apellidos'] . "\n";
            }
            $pdf->writeHTML($content);

            // Salida del PDF
            $pdf->Output('employee_list.pdf', 'D');
        }
        exit();
    }
}
?>
