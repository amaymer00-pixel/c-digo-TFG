<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../favicon.png">
    <title>Presentaciones PRL - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="../../estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .grid-pdf {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .tarjeta-pdf {
            padding: 20px;
            text-align: center;
            border-top: 4px solid #000;
        }
        .icon-pdf {
            font-size: 3em;
            color: #e74c3c;
            margin-bottom: 15px;
        }
        .archivo-nombre {
            font-size: 1em;
            margin-bottom: 20px;
            color: #333;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .boton-volver {
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="../../logo.png" alt="" width="45">
            <h1>SMR INDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="../../index">Inicio</a>
            <a href="../../perfil">Perfil</a>
            <a href="../../miscursos">Mis cursos</a>
            <a href="../../login">Desconectarse</a>
        </nav>
    </header>

    <main class="seccion-tarjetas">
        <a href="../../formación" class="boton boton-volver"><i class="fas fa-arrow-left"></i> Volver a Formación</a>
        
        <h2 class="titulo-seccion">Guías y Presentaciones PRL</h2>
        <p style="text-align: center; color: #666;">Seleccione un documento para visualizarlo en una nueva pestaña.</p>

        <div class="grid-pdf">
            <?php
            $pdfs = glob("*.pdf");

            if (count($pdfs) > 0) {
                foreach ($pdfs as $archivo) {
                    $nombreLimpio = str_replace(".pdf", "", $archivo);
                    ?>
                    <article class="tarjetas tarjeta-pdf">
                        <i class="fas fa-file-pdf icon-pdf"></i>
                        <div class="archivo-nombre">
                            <strong><?php echo htmlspecialchars($nombreLimpio); ?></strong>
                        </div>
                        <a href="<?php echo $archivo; ?>" target="_blank" class="boton" style="justify-self: center;">
                            <i class="fas fa-external-link-alt"></i> Abrir Documento
                        </a>
                    </article>
                    <?php
                }
            }
            ?>
        </div>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>