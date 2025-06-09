<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
</head>
<body>
    <header class="container" style="margin-bottom: 1.5rem;">
        <h1 style="text-align:center;">Bienvenido a la Aplicación de Eventos Culturales</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                <li><a class="btn" href="../../src/vistas/register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="../controladores/login.controller.php">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>
            <button type="submit">Entrar</button>
        </form>
        <div style="margin-top: 24px; color: #555; font-size: 1em; background: #f9f9f9; border-radius: 8px; padding: 18px;">
            <h3 style="color:#35424a; margin-top:0;">¿Por qué registrarte?</h3>
            <ul style="text-align:left; margin: 0 0 0 1.2em;">
                <li>Accede a eventos exclusivos y destacados de tu ciudad.</li>
                <li>Guarda tus eventos favoritos y recibe notificaciones.</li>
                <li>Participa en la comunidad cultural y comparte tus experiencias.</li>
            </ul>
            <p style="margin-top:1em;">¿No tienes cuenta? <a href="../vistas/register.php" style="color:#35424a; font-weight:bold;">Regístrate aquí</a>.</p>
        </div>
    </div>
    <footer class="footer-main">
        <div class="footer-logo">CulturaGo</div>
        <div class="footer-links">
            <a href="/app/cultural-events-app/src/vistas/landing.php">Inicio</a> |
            <a href="/app/cultural-events-app/src/vistas/eventos.php">Eventos</a> |
            <a href="/app/cultural-events-app/src/vistas/login.php">Iniciar Sesion</a>
        </div>
        <div>
            &copy; <?php echo date("Y"); ?> CulturaGo. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>