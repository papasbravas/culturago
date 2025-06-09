<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
</head>
<body>
    <header class="container" style="margin-bottom: 1rem;">
        <h1 style="text-align:center;">Zona de Registro</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <li><a class="btn" href="/app/cultural-events-app/src/vistas/misreservas.php">Mis reservas</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="login-container" style="max-width:400px; margin:40px auto;">
        <h2>Crear cuenta</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alerta-error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        <form method="POST" action="../controladores/register.controller.php" class="form-registro">
            <label>Nombre de usuario:
                <input type="text" name="nombre" required>
            </label>
            <label>Email:
                <input type="email" name="email" required>
            </label>
            <label>Contraseña:
                <input type="password" name="contrasena" required>
            </label>
            <button type="submit" class="btn">Registrarse</button>
        </form>
        <p style="margin-top:1rem;">¿Ya tienes cuenta? <a href="../controladores/login.controller.php">Inicia sesión</a></p>
    </main>
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