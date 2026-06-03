<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login");
    exit();
}

include("conexion.php"); 

try {
    // 1. Obtener datos del empleado
    $sql = "SELECT id_usuario, usuario, nombre, puesto, departamento, correo, telefono FROM empleados WHERE usuario = :user";
    $resultado = $base->prepare($sql);
    $resultado->bindValue(":user", $_SESSION['usuario']);
    $resultado->execute();
    $usuario = $resultado->fetch(PDO::FETCH_ASSOC);
    
    $sql_activos = "SELECT c.nombre_curso, c.url_curso 
                    FROM progreso p
                    INNER JOIN cursos c ON p.id_curso = c.id_curso
                    WHERE p.id_usuario = :id_u AND p.estado = 'En curso'";
    
    $stmt_act = $base->prepare($sql_activos);
    $stmt_act->execute([':id_u' => $usuario['id_usuario']]);
    $cursos_activos = $stmt_act->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $excepcion) {
    echo "Error en el perfil: " . $excepcion->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - SMR INDUSTRIES</title>
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

    .contenedor-perfil { 
        max-width: 1200px; 
        margin: 40px auto; 
        padding: 20px; 
    }

    .grid-perfil { 
        display: grid; 
        grid-template-columns: 320px 1fr; 
        gap: 40px; 
        align-items: start; 
    }

    .datos-usuario { 
        background: #fff; 
        border: 1px solid rgba(0,0,0,0.1); 
        border-radius: 8px; overflow: hidden; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
    }

    .tabla-horario { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 30px; 
        background: #fff; 
    }

    .tabla-horario th { 
        background-color: #000; 
        color: #fff; 
        padding: 12px; 
        text-align: center; 
    }

    .tabla-horario td { 
        border: 1px solid #ddd; 
        padding: 12px; 
        text-align: center; 
    }

    .titulo-interior { 
        border-bottom: 2px solid #000; 
        padding-bottom: 10px; 
        margin-bottom: 20px; 
        text-transform: uppercase; 
    }

    .grid-seccion-tarjetas { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
        gap: 20px; 
        max-height: 480px; 
        overflow-y: auto; 
        padding: 10px;
        background: #fdfdfd;
        border-radius: 8px;
        border: 1px inset rgba(0,0,0,0.05);
    }

    .grid-seccion-tarjetas::-webkit-scrollbar {
        width: 8px;
    }

    .grid-seccion-tarjetas::-webkit-scrollbar-thumb {
         background: #ccc;
        border-radius: 10px;
    }
    
    .grid-seccion-tarjetas::-webkit-scrollbar-thumb:hover {
        background: #000;
    }

    .tarjetas { 
        background: #fff; 
        border: 1px solid #eee; 
        padding: 15px; 
        border-radius: 6px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        display: grid;
        align-content: space-between;
    }

        @media (max-width: 900px) { .grid-perfil { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <div><img src="./logo.png" alt="" width="45"><h1>SMRINDUSTRIES</h1></div>
        <nav class="nav">
            <a href="index">Inicio</a>
            <a href="perfil">Perfil</a>
            <a href="miscursos">Mis cursos</a>
            <a href="logout">Desconectarse</a>
        </nav>
    </header>

    <main class="contenedor-perfil">
        <h2 class="titulo-seccion">Portal del Empleado</h2>
        <div class="grid-perfil">
            <aside class="datos-usuario">
                <div style="padding: 20px;">
                    <h3><?php echo htmlspecialchars($usuario['nombre']); ?></h3>
                    <p><strong>Dpto</strong><br><?php echo htmlspecialchars($usuario['departamento']); ?></p>
                    <p><strong>Puesto</strong><br><?php echo htmlspecialchars($usuario['puesto']); ?></p>
                    <p><strong>Email</strong><br><?php echo htmlspecialchars($usuario['correo']); ?></p>
                </div>
            </aside>

            <section class="perfil-contenido">
                <h3 class="titulo-interior">Horario Laboral</h3>
                <table class="tabla-horario">
                    <thead><tr><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th></tr></thead>
                    <tbody>
                        <tr><td>08:00-15:00</td><td>08:00-15:00</td><td>08:00-15:00</td><td>08:00-17:00</td><td>08:00-14:00</td></tr>
                        <tr style="background:#f9f9f9; font-style:italic;"><td>Presencial</td><td>Presencial</td><td>Teletrabajo</td><td>Presencial</td><td>Teletrabajo</td></tr>
                    </tbody>
                </table>

                <h3 class="titulo-interior">Cursos Activos</h3>
                <div class="grid-seccion-tarjetas">
                    <?php if (!empty($cursos_activos)): ?>
                        <?php foreach ($cursos_activos as $curso): ?>
                        <article class="tarjetas">
                            <div class="contenido-tarjeta">
                                <h4><?php echo htmlspecialchars($curso['nombre_curso']); ?></h4>
                                <a href="<?php echo htmlspecialchars($curso['url_curso']); ?>" class="boton" target="_blank">Ver Material</a>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1 / -1; color: #666;">No hay cursos pendientes.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>
    <footer><p>SMRINDUSTRIES.</p></footer>
</body>
</html>