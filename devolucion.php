<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';

$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    header("Location: inventario.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->execute([$id_producto]);
$producto = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST['id_empleado'];
    $cantidad = $_POST['cantidad'];

    $updateStock = $pdo->prepare("UPDATE productos SET stock = stock + ? WHERE id_producto = ?");
    $updateStock->execute([$cantidad, $id_producto]);

    $insertTransaccion = $pdo->prepare("INSERT INTO transacciones (id_empleado, id_producto, accion, cantidad, notas) VALUES (?, ?, 'devolucion', ?, ?)");
    $insertTransaccion->execute([$id_empleado, $id_producto, $cantidad, "Devolución técnica"]);

    $updateEmp = $pdo->prepare("UPDATE inventario_empleado SET cantidad = cantidad - ? WHERE id_empleado = ? AND id_producto = ?");
    $updateEmp->execute([$cantidad, $id_empleado, $id_producto]);

    header("Location: inventario.php?msg=ok");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Devolución - SMRINDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <div><img src="./logo.png" alt="" width="45"><h1>SMR INDUSTRIES</h1></div>
        <nav class="nav">
            <a href="inventario.php">Volver</a>
        </nav>
    </header>
    <main class="seccion-tarjetas">
        <h2 class="titulo-seccion">Retorno de Material</h2>
        <section class="formulario">
            <p>Producto: <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></p>
            <form method="POST">
                <div class="campos-formulario">
                    <label>ID del Técnico:</label>
                    <input type="number" name="id_empleado" class="nombre" required>
                </div>
                <div class="campos-formulario">
                    <label>Cantidad a devolver:</label>
                    <input type="number" name="cantidad" class="nombre" required min="1">
                </div>
                <input type="submit" value="Confirmar Devolución" class="boton-submit">
            </form>
        </section>
    </main>
</body>
</html>