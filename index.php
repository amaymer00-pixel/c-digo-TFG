<?php
session_start();
if (!isset ($_SESSION["usuario"] ) ) {
header ("Location: login");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div>
            <img src="./logo.png" alt="" width="45">
            <h1>SMRINDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main>
        <section class="cabecera" id="inicio">
            <div class="cabecera-texto">
                <h2>Bienvenido/a de nuevo</h2><br>
                <h1><?php
                echo htmlspecialchars ($_SESSION['nombre']);
                ?></h1>
            </div>
        </section>

        <section class="seccion-tarjetas">
            <h2 class="titulo-seccion">Portal del empleado</h2>
            <div class="grid-seccion-tarjetas">

                <article class="tarjetas" id="cruceros">
                    <div class="contenido-tarjeta">
                        <h3>Noticias</h3>
                        <p>Entérate de las últimas noticias relacionadas con tu puesto de trabajo.</p>
                        <a href="noticias_empresariales" class="boton">Accede</a>
                    </div>
                </article>


                <article class="tarjetas" id="vuelos">
                    <div class="contenido-tarjeta">
                        <h3>Formación</h3>
                        <p>En esta sección encontrarás cursos, vídeos, artículos y otros recursos dedicados a tu formación.</p>
                        <a href="formación" class="boton">Accede</a>
                    </div>
                </article>

                                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <h3>Inventario</h3>
                        <p>Material en Stock</p>
                        <a href="inventario" class="boton">Accede</a>
                    </div>
                </article>

                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <h3>Herramientas</h3>
                        <p>Encuentra y descarga las herramientas que se usarán en tu puesto de trabajo.</p>
                        <a href="./recursos/herramientas" class="boton">Accede</a>
                    </div>
                </article>

                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <h3>Eventos</h3>
                        <p>En esta sección podrás estar pendiente de los eventos realizados por la empresa.</p>
                        <a href="eventos_empresariales" class="boton">Accede</a>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
            <p>SMRINDUESTRIES.</p>
        </div>
    </footer>
    
</body>
</html>