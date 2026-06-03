<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}

require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll();
} catch (PDOException $excepcion) {
    echo "DEBUG ERROR: " . $excepcion->getMessage(); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Inventario - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css?v=1.5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
body {
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-rows: auto 1fr auto;
        min-height: 100vh; 
        font-family: 'Lora', serif;
    }

    main {
        padding: 20px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        box-sizing: border-box;
    }
        .cabecera-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            margin-bottom: 20px;
        }
        .acciones-grid {
            display: grid;
            grid-template-columns: auto auto;
            gap: 10px;
            justify-content: center;
        }

        .btn-tabla {
            padding: 5px 10px !important;
            font-size: 0.8em !important;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="./logo.png" alt="" width="45">
            <h1>SMR INDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main class="contenedor-perfil">
        <div class="cabecera-grid">
            <h2 class="titulo-seccion" style="margin: 0;">Gestión de Inventario</h2>
            <a href="nuevo_producto" class="boton" style="margin: 0;">
                <i class="fas fa-plus"></i> Agregar Nuevo Producto
            </a>
        </div>

        <section class="seccion-cursos-usuario">
            <h3 class="titulo-interior">Material en Stock</h3>
            <table class="tabla-horario">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Código de Barras</th>
                        <th>Stock Actual</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id_producto']; ?></td>
                        <td style="text-align: left;">
                            <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong><br>
                            <small><?php echo htmlspecialchars($producto['descripcion']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                        <td><code><?php echo htmlspecialchars($producto['codigo_barras']); ?></code></td>
                        <td style="font-weight: bold; <?php echo ($producto['stock'] < 5) ? 'color: red;' : ''; ?>">
                            <?php echo $producto['stock']; ?>
                        </td>
                        <td>
                            <div class="acciones-grid">
                                <a href="asignar.php?id=<?php echo $producto['id_producto']; ?>" class="boton btn-tabla">Asignar</a>
                                <a href="devolucion.php?id=<?php echo $producto['id_producto']; ?>" class="boton btn-tabla">Devolver</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="seccion-cursos-usuario" style="margin-top: 30px;">
            <h3 class="titulo-interior">Últimos Movimientos</h3>
            <p>Consulta las asignaciones y devoluciones recientes del personal técnico.</p>
            <a href="transacciones" class="boton">Ver Historial Completo</a>
        </section>
    </main>

    <footer>
        <p>SMRINDUSTRIES.</p>
    </footer>
</body>
</html>