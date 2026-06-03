<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}
include("conexion.php");

try {
    $sql = "SELECT c.nombre_curso, c.url_curso 
            FROM progreso p
            INNER JOIN cursos c ON p.id_curso = c.id_curso 
            INNER JOIN empleados e ON p.id_usuario = e.id_usuario
            WHERE e.usuario = :user AND p.estado = 'Finalizado'";
    
    $stmt = $base->prepare($sql);
    $stmt->execute([':user' => $_SESSION['usuario']]);
    $completados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $excepcion) {
    die("Error: " . $excepcion->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Mis Cursos - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
    body {
    margin: 0;
    padding: 0;
    display: grid;
    grid-template-rows: auto 1fr auto; 
    min-height: 100vh;
}
    main {
    display: block; 
    width: 100%;
}
    </style>
</head>
<body>
    <header>
        <div><img src="./logo.png" alt="" width="45">
        <h1>SMRINDUSTRIES</h1></div>
        <nav class="nav">
            <a href="index">Inicio</a><a href="perfil">Perfil</a><a href="miscursos">Mis cursos</a><a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main class="seccion-tarjetas">
        <h2 class="titulo-seccion">Formación Finalizada</h2>
        <div class="grid-seccion-tarjetas">
            <?php if (!empty($completados)): ?>
                <?php foreach ($completados as $c): ?>
                <article class="tarjetas">
                        <span class="curso-estado completado">Finalizado</span>
                    <div class="contenido-tarjeta">
                        <h3><?php echo htmlspecialchars($c['nombre_curso']); ?></h3>
                        <a href="<?php echo $c['url_curso']; ?>" class="boton" target="_blank">Repasar PPT</a>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; text-align: center;">Aún no has terminado ningún curso.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer><p>SMRINDUSTRIES.</p></footer>
</body>
</html>