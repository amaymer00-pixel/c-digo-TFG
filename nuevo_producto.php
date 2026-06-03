<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Nuevo Producto - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css?v=1.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .formulario select, .formulario textarea, .formulario input[type="text"], .formulario input[type="number"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            font-family: 'Lora', serif;
            width: 100%;
            background-color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .formulario input:focus, .formulario textarea:focus {
            border-color: #000;
            outline: none;
        }

        .formulario textarea {
            resize: vertical;
            min-height: 100px;
        }

        .campos-formulario {
            padding: 10px 0;
            display: grid;
            gap: 8px;
        }

        .campos-formulario label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85em;
            color: #444;
        }
    </style>
</head>
<body>
    
    <header>
        <div>
            <img src="./logo.png" alt="" width="45">
            <h1>Añadir producto - SMRINDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main>
        <section class="contenedor-perfil">
            <h2 class="titulo-seccion">Registrar Nuevo Material</h2>
            <div class="formulario seccion-cursos-usuario" style="max-width: 700px; margin: 0 auto;">
                <h3 class="titulo-interior">Detalles del Producto</h3>
                
                <form action="procesar_stock.php" method="POST">
                    
                    <div class="campos-formulario">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Router Cisco ISR 4331" required>
                    </div>

                    <div class="campos-formulario">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecciona una categoría...</option>
                            <option value="Redes">Redes</option>
                            <option value="Herramientas">Herramientas</option>
                            <option value="Cableado">Cableado</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="campos-formulario">
                        <label for="codigo_barras">Código de Barras</label>
                        <input type="text" id="codigo_barras" name="codigo_barras" placeholder="Ingrese el código SKU o EAN">
                    </div>

                    <div class="campos-formulario">
                        <label for="stock">Stock Inicial</label>
                        <input type="number" id="stock" name="stock" min="0" value="0" required>
                    </div>

                    <div class="campos-formulario">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Especificaciones técnicas, estado del material..."></textarea>
                    </div>

                    <div class="campos-formulario" style="margin-top: 20px;">
                        <button type="submit" class="boton-submit">Guardar en Inventario</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="eco">
        <div class="footer-bottom-eco">
            <p>SMRINDUSTRIES.</p>
        </div>
    </footer>
    
</body>
</html>