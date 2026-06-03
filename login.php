<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: index");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Login - SMR INDUSTRIES</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="loginbody">
    <main>
        <form action="validacion.php" method="POST" class="loginbody">
            <section style="display: grid; gap: 20px; background-color: #ffffff; padding: 40px; border-radius: 8px; width: 100%; max-width: 400px;">
                <h1>Bienvenido</h1>
                <p>Ingresa tus credenciales para continuar</p>

                <?php if (isset($_GET['error'])): ?>
                    <p style="color: red; font-size: 0.9em;">Usuario o password incorrectos.</p>
                <?php endif; ?>
                
                <div class="input-box">
                    <input type="text" name="usuario" placeholder="Usuario" required>
                </div>
                
                <div class="input-box">
                    <input type="password" name="password" placeholder="password" required>
                </div>
                
                <input class="boton" type="submit" name="entrar" value="login">
            </section>
        </form>
    </main>
</body>
</html>