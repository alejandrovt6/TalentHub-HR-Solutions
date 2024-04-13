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

<?php include_once("../includes/header-admin.php");?>

    <main>
        <h1>BIENVENIDO, </h1>
        <div class="container">
        <h2>Descubre lo que Talent Hub HR Solutions tiene para ofrecerte:</h2>
            <p>Somos una empresa dedicada a proporcionar soluciones integrales en recursos humanos para empresas de todos los tamaños. Nuestro objetivo es ayudarte a optimizar la gestión del talento en tu organización y a impulsar el crecimiento de tu negocio.</p>
            <h3>Nuestros servicios incluyen:</h3>
            <ul>
                <li><strong>Selección de personal:</strong> Te ayudamos a encontrar a los mejores candidatos para tus vacantes, utilizando técnicas de reclutamiento innovadoras y evaluaciones exhaustivas.</li>
                <li><strong>Desarrollo de talento:</strong> Ofrecemos programas de formación y desarrollo personalizados para potenciar las habilidades y competencias de tu equipo.</li>
                <li><strong>Gestión del rendimiento:</strong> Implementamos sistemas y herramientas para medir y mejorar el desempeño de tus empleados, fomentando un ambiente de trabajo productivo y motivador.</li>
                <li><strong>Consultoría estratégica:</strong> Te asesoramos en la elaboración de estrategias de recursos humanos que impulsen el crecimiento sostenible de tu empresa y te ayuden a alcanzar tus objetivos empresariales.</li>
            </ul>
            <p>No importa cuáles sean tus necesidades en recursos humanos, en Talent Hub HR Solutions estamos aquí para ayudarte a alcanzar el éxito. ¡Contáctanos hoy mismo para conocer más sobre nuestros servicios!</p>
        </div>
    </main>

<?php include_once("../includes/footer.php");?>





