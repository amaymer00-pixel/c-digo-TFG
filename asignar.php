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


    if ($producto['stock'] >= $cantidad) {
        

        $updateStock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
        $updateStock->execute([$cantidad, $id_producto]);


        $insertAsignacion = $pdo->prepare("INSERT INTO inventario_empleado (id_empleado, id_producto, cantidad) VALUES (?, ?, ?)");
        $insertAsignacion->execute([$id_empleado, $id_producto, $cantidad]);


        $insertTransaccion = $pdo->prepare("INSERT INTO transacciones (id_empleado, id_producto, accion, cantidad, notas) VALUES (?, ?, 'asignación', ?, ?)");
        $insertTransaccion->execute([$id_empleado, $id_producto, $cantidad, "Asignado vía intranet"]);
        header("Location: inventario.php?msg=Asignado correctamente");
        exit();
        
    } else {
        $error = "No hay stock suficiente para realizar la asignación.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Material - SMRINDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" type="image/x-icon" href="favicon.png">
</head>
<body>
    <header>
        <div><img src="./logo.png" alt="" width="45"><h1>SMR INDUSTRIES</h1></div>
        <nav class="nav">
            <a href="inventario.php">Volver al Inventario</a>
        </nav>
    </header>

    <main class="seccion-tarjetas">
        <h2 class="titulo-seccion">Asignar Material a Técnico</h2>
        
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>

        <section class="formulario">
            <p>Vas a asignar: <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></p>
            <p>Stock disponible: <strong><?php echo $producto['stock']; ?></strong></p>

            <form method="POST">
                <div class="campos-formulario">
                    <label>ID del Empleado / Técnico:</label>
                    <input type="number" name="id_empleado" class="nombre" required placeholder="ID del técnico">
                </div>
                <div class="campos-formulario">
                    <label>Cantidad a entregar:</label>
                    <input type="number" name="cantidad" class="nombre" required min="1" max="<?php echo $producto['stock']; ?>">
                </div>
                <input type="submit" value="Confirmar Asignación" class="boton-submit">
            </form>
        </section>
    </main>
</body>
</html>