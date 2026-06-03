<?php
session_start();
if (!isset ($_SESSION["usuario"] ) ) {
header ("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Formación - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div><img src="./logo.png" alt="" width="45"><h1>SMRINDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main>
        <section class="seccion-tarjetas">
            <h2 class="titulo-seccion">Cursos y formacion Disponibles</h2>
            
            <div class="grid-seccion-tarjetas">

                <article class="tarjetas">
                    <div class="imagen-tarjeta">
                        <img src="./images/bienvenida.png" alt="Equipo de trabajo sonriendo">
                    </div>
                    <div class="contenido-tarjeta">
                        <h3>Inducción Corporativa</h3>
                        <p>Video de bienvenida donde conocerás la visión, misión y valores de SMR INDUSTRIES.</p>
                        <a href="formacion/video-induccion.mp4" target="_self" class="boton">Ver Video</a>
                    </div>
                </article>

                <article class="tarjetas">
                    <div class="imagen-tarjeta">
                        <img src="./images/prl.png" alt="Casco de seguridad y guantes">
                    </div>
                    <div class="contenido-tarjeta">
                        <h3>Introducción prevención de riesgos laborales</h3>
                        <p>Material obligatorio sobre salud laboral y ergonomía en el puesto de trabajo.</p>
                        <a href="./formacion/videos/prl.mp4" target="_self" class="boton">Ver video</a>
                    </div>
                </article>

                <article class="tarjetas">
                    <div class="imagen-tarjeta">
                        <img src="./images/guia.png" alt="Pantalla de código y logo de XAMPP">
                    </div>
                    <div class="contenido-tarjeta">
                        <h3>Presentaciones de PRL</h3>
                        <p>PDF explicativos en cuestiones de prevención de riesgos laborales. Preparación para los cursos de PRL.</p>
                        <a href="./formacion/powerpoint/guias.php" target="_self" class="boton">Abrir</a>
                    </div>
                </article>

                <article class="tarjetas">
                    <div class="imagen-tarjeta">
                        <img src="./images/manual.png" alt="Ciberseguridad y candado digital">
                    </div>
                    <div class="contenido-tarjeta">
                        <h3>Manual de Seguridad IT</h3>
                        <p>Documento detallado sobre los protocolos de ciberseguridad y manejo de datos en la empresa.</p>
                        <a href="formacion/pdf/Guia_Mantenimiento_Sistemas_Telecom.pdf" target="_blank" class="boton">Ver PDF</a>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>