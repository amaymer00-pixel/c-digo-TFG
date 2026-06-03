<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}

$noticias = [
];

$directorio = 'documentos/noticias/';
$documentos_dinamicos = [];

if (is_dir($directorio)) {
    $archivos = preg_grep('~\.(html|htm)$~', scandir($directorio));
    foreach ($archivos as $archivo) {
        $documentos_dinamicos[] = [
            'titulo' => str_replace(['.html', '.htm', '_', '-'], ['', '', ' ', ' '], $archivo),
            'archivo' => $archivo,
            'fecha' => date("d M, Y", filemtime($directorio . $archivo)),
            'categoria' => 'Documentación'
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
    <title>Noticias - SMR INDUSTRIES</title>
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
        <div>
            <img src="./logo.png" alt="" width="45">
            <h1>NOTICIAS - SMR INDUSTRIES</h1>
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
            <h2 class="titulo-seccion">Actualidad y Documentos</h2>
            
            <div class="grid-seccion-tarjetas">
                <?php foreach ($noticias as $noticia): ?>
                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <span class="etiqueta-noticia"><?php echo $noticia['categoria']; ?></span>
                        <h3><?php echo $noticia['titulo']; ?></h3>
                        <p class="fecha-noticia"><i class="far fa-calendar-alt"></i> <?php echo $noticia['fecha']; ?></p>
                        <p><?php echo $noticia['resumen']; ?></p>
                        <a href="#" class="boton">Leer más</a>
                    </div>
                </article>
                <?php endforeach; ?>

                <?php foreach ($documentos_dinamicos as $doc): ?>
                <article class="tarjetas">
                    <div class="contenido-tarjeta">
                        <span class="etiqueta-noticia" style="background-color: #333;"><?php echo $doc['categoria']; ?></span>
                        <h3><?php echo ucwords($doc['titulo']); ?></h3>
                        <p class="fecha-noticia"><i class="far fa-calendar-alt"></i> <?php echo $doc['fecha']; ?></p>
                        <p>Documento de texto disponible solo para empleados</p>
                        <a href="visualizar.php?file=<?php echo urlencode($doc['archivo']); ?>" class="boton">Ver Documento</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>