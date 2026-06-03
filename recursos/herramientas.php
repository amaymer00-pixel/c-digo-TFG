<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.png">
    <title>Centro de Software - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .grid-instaladores {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .tarjeta-software {
            background: #fff;
            padding: 20px;
            text-align: center;
            border-top: 4px solid #000; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .tarjeta-software:hover {
            transform: translateY(-5px);
        }
        .categoria-label {
            font-size: 0.75em;
            text-transform: uppercase;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 10px;
            display: block;
        }
        .icon-app {
            font-size: 3em;
            color: #333;
            margin-bottom: 15px;
        }
        .nombre-app {
            font-size: 1.3em;
            color: #000;
            margin-bottom: 10px;
            font-family: 'Lora', serif;
        }
        .descripcion-app {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 20px;
            min-height: 40px;
        }
        .info-tecnica-box {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.85em;
            color: #555;
            text-align: left;
        }

        .boton-descarga {
            width: 300px;
        }

        .boton-descarga:hover {

        }
        .vacio-msg {
            text-align: center;
            grid-column: 1/-1;
            padding: 50px;
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
            <a href="../index">Inicio</a>
            <a href="../perfil">Perfil</a>
            <a href="../miscursos">Mis cursos</a>
            <a href="../logout">Desconectarse</a>
        </nav>
    </header>

    <main class="seccion-tarjetas">
        <a href="../../index" class="boton boton-volver"><i class="fas fa-arrow-left"></i> Volver al Panel</a>
        
        <h2 class="titulo-seccion">Repositorio de Herramientas IT</h2>
        <p style="text-align: center; color: #666;">Software oficial para análisis de red, diagnóstico y gestión de sistemas.</p>

        <div class="grid-instaladores">
            <?php
            $catalogo = [
                "wireshark"      => ["cat" => "Análisis de Red", "desc" => "Analizador de protocolos de red.", "icon" => "fa-microscope"],
                "angry ip"       => ["cat" => "Escaneo IP", "desc" => "Escáner de direcciones IP y puertos.", "icon" => "fa-search-location"],
                "windirstat"     => ["cat" => "Gestión de Disco", "desc" => "Visualizador de uso de estadísticas de espacio en disco.", "icon" => "fa-chart-pie"],
                "rustdesk"       => ["cat" => "Acceso Remoto", "desc" => "Software de escritorio remoto.", "icon" => "fa-desktop"],
                "putty"          => ["cat" => "Terminal SSH", "desc" => "Cliente SSH y telnet para gestión remota de servidores.", "icon" => "fa-terminal"],
                "nmap"           => ["cat" => "Seguridad de Red", "desc" => "Herramienta de exploración de red y auditoría de seguridad.", "icon" => "fa-shield-alt"],
                "crystal disk"   => ["cat" => "Diagnóstico HDD/SSD", "desc" => "Monitor de estado de salud para unidades de almacenamiento.", "icon" => "fa-heartbeat"]
            ];

            $archivos = glob("*.{exe,msi,EXE,MSI}", GLOB_BRACE);

            if (count($archivos) > 0) {
                foreach ($archivos as $archivo) {
                    $info = pathinfo($archivo);
                    $ext = strtolower($info['extension']);
                    $nombreFile = strtolower($info['filename']);
                    
                    $categoria = "Utilidad";
                    $descripcion = "Instalador de software para sistemas.";
                    $icono = "fa-file-download";
                    $nombreDisplay = ucwords(str_replace(["-", "_"], " ", $info['filename']));

                    foreach ($catalogo as $key => $datos) {
                        if (strpos($nombreFile, $key) !== false) {
                            $categoria = $datos['cat'];
                            $descripcion = $datos['desc'];
                            $icono = $datos['icon'];
                            $nombreDisplay = ucwords($key);
                            break;
                        }
                    }

                    $peso = round(filesize($archivo) / (1024 * 1024), 2);
                    ?>
                    
                    <article class="tarjeta-software">
                        <div>
                            <span class="categoria-label"><?php echo $categoria; ?></span>
                            <i class="fas <?php echo $icono; ?> icon-app"></i>
                            <h3 class="nombre-app"><?php echo $nombreDisplay; ?></h3>
                            <p class="descripcion-app"><?php echo $descripcion; ?></p>
                        </div>

                        <div>
                            <div class="info-tecnica-box">
                                <strong><i class="fas fa-file-code"></i> Formato:</strong> .<?php echo $ext; ?><br>
                                <strong><i class="fas fa-weight-hanging"></i> Tamaño:</strong> <?php echo $peso; ?> MB
                            </div>
                            <a href="<?php echo $archivo; ?>" download class="boton">
                                <i class="fas fa-download"></i> <div class="boton-descarga">DESCARGAR</div>
                            </a>
                        </div>
                    </article>

                    <?php
                }
            } else {
                echo "<div class='vacio-msg'><h3>No se encontraron instaladores en la carpeta.</h3><p>Suba archivos .exe o .msi para visualizarlos aquí.</p></div>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>