<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$query = "SELECT t.*, p.nombre as producto_nombre 
          FROM transacciones t 
          LEFT JOIN productos p ON t.id_producto = p.id_producto 
          ORDER BY t.fecha DESC";

$stmt = $pdo->query($query);
$movimientos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Movimientos - SMRINDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css?v=1.7">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <style>
        body {
            display: grid;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
            margin: 0;
        }
        main {
            padding: 20px;
        }
        .cabecera-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            align-items: center;
            margin-bottom: 40px;
            padding: 10px 0;
        }
        .accion {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }
        .asignacion { 
            background-color: #e3f2fd; 
            color: #1976d2; 
            border: 1px solid #1976d2; 
        }
        .devolucion { 
            background-color: #e8f5e9; 
            color: #2e7d32;
            border: 1px solid #2e7d32; 
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="./logo.png" alt="" width="45">
            <h1>SMRINDUSTRIES</h1>
        </div>
        <nav class="nav">
            <a href="index.php">Inicio</a>
            <a href="perfil.php">Perfil</a>
            <a href="miscursos.php">Mis cursos</a>
            <a href="logout.php">Desconectarse</a>
        </nav>
    </header>

    <main class="contenedor-perfil">
        <div class="cabecera-grid">
            <h2 class="titulo-seccion" style="margin: 0;">HISTORIAL DE MOVIMIENTOS</h2>
            <a href="inventario.php" class="boton" style="margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> Volver al Inventario
            </a>
        </div>

        <section class="seccion-cursos-usuario">
            <h3 class="titulo-interior">REGISTRO DE ACTIVIDAD</h3>
            
            <?php if (empty($movimientos)): ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-info-circle" style="font-size: 2em; margin-bottom: 10px;"></i>
                    <p>No hay movimientos registrados recientemente. <br> 
                    <small>Las transacciones aparecerán aquí cuando asignes o devuelvas material.</small></p>
                </div>
            <?php else: ?>
                <table class="tabla-horario" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>FECHA Y HORA</th>
                            <th>PRODUCTO</th>
                            <th>USUARIO / TÉCNICO</th>
                            <th>ACCION</th>
                            <th>CANTIDAD</th>
                            <th>NOTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $transaccion): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($transaccion['fecha'])); ?></td>
                            <td style="text-align: left;"><strong><?php echo htmlspecialchars($transaccion['producto_nombre'] ?? 'Producto Eliminado'); ?></strong></td>
                            <td><?php echo htmlspecialchars($transaccion['id_empleado'] ?? $transaccion['usuario'] ?? 'Sistema'); ?></td>
                            <td>
                                <?php 
                                    // Comprobación de la acción mucho más natural para un estudiante
                                    $accion = $transaccion['accion'] ?? 'Movimiento';
                                    
                                    if ($accion == 'asignacion') {
                                        $clase = 'asignacion';
                                    } else {
                                        $clase = 'devolucion';
                                    }
                                ?>
                                <span class="accion <?php echo $clase; ?>">
                                    <?php echo htmlspecialchars($accion); ?>
                                </span>
                            </td>
                            <td><?php echo $transaccion['cantidad']; ?></td>
                            <td style="font-size: 0.9em; color: #666;"><?php echo htmlspecialchars($transaccion['notas'] ?? ''); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>

    <footer class="eco">
        <div class="footer-bottom-eco">
            <p>SMRINDUSTRIES.</p>
        </div>
    </footer>
</body>
</html>