<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}
header('Content-Type: text/html; charset=utf-8');
$directorio = 'documentos/eventos/';
$documentos_eventos = [];

if (is_dir($directorio)) {
    $archivos = preg_grep('~\.(html|htm)$~', scandir($directorio));
    foreach ($archivos as $archivo) {
        $documentos_eventos[] = [
            'titulo' => str_replace(['.html', '.htm', '_', '-'], ['', '', ' ', ' '], $archivo),
            'archivo' => $archivo,
            'fecha' => date("d M, Y", filemtime($directorio . $archivo)),
            'categoria' => 'Evento'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Eventos - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            display: grid; 
            grid-template-rows: auto 1fr auto; 
            min-height: 100vh; 
        }
    </style>
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

    <main>
        <section class="seccion-tarjetas">
            <h2 class="titulo-seccion">Próximos Eventos</h2>
            <div class="grid-seccion-tarjetas">
                <?php foreach ($documentos_eventos as $doc): ?>
                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <span class="etiqueta-noticia" style="background-color: #ce8e00;"><?php echo $doc['categoria']; ?></span>
                        <h3><?php echo ucwords($doc['titulo']); ?></h3>
                        <p class="fecha-noticia"><i class="far fa-calendar-alt"></i> <?php echo $doc['fecha']; ?></p>
                        <p>Haz clic para ver los detalles y la planificación de este evento.</p>
                        <a href="visualizar.php?file=<?php echo urlencode($doc['archivo']); ?>&type=eventos" class="boton">Ver Detalles</a>
                    </div>
                </article>
                <?php endforeach; ?>

            </div>
        </section>
    </main>

    <footer><p>SMRINDUSTRIES.</p></footer>
</body>
</html>