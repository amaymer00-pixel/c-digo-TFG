<?php
session_start();
if (!isset($_SESSION["usuario"])) { header("Location: login"); exit(); }

$archivo = $_GET['file'] ?? '';
$tipo = $_GET['type'] ?? 'noticias'; 
$ruta = "documentos/" . $tipo . "/" . $archivo;

if (empty($archivo) || !file_exists($ruta)) { 
    die("Documento no encontrado."); 
}

$contenido = file_get_contents($ruta);
$codificacion = mb_detect_encoding($contenido, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);

if ($codificacion !== 'UTF-8') {
    $contenido = mb_convert_encoding($contenido, 'UTF-8', $codificacion);
}


if (preg_match('/<body[^>]*>(.*?)<\\/body>/is', $contenido, $matches)) {
    $contenido = $matches[1];
}

$contenido = preg_replace('/<meta[^>]+>/i', '', $contenido);
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Visor - SMR INDUSTRIES</title>
    <link rel="icon" type="image/x-icon" href="favicon.png">
</head>
<body>
    <header>
    <div><img src="./logo.png" alt="" width="45"><h1>SMR INDUSTRIES</h1></div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main class="contenedor-perfil">
        <section class="seccion-cursos-usuario" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div class="contenido-html">
                <?php echo $contenido; ?>
            </div>
            <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">
            <center><a href="javascript:history.back()" class="boton">Volver atrás</a></center>
        </section>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>