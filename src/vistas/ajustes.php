<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ajustes de Usuario</title>
    <link rel="stylesheet" href="/app/cultural-events-app/public/assets/style.css">
</head>
<body>
    <header class="container" style="margin-bottom: 1rem;">
        <h1 style="text-align:center;">Ajustes de usuario</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="logout.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../controladores/misfavoritos.controller.php">Mis Favoritos</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                    <a class="btn" href="../vistas/register.php">Registrarse</a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="ajustes-container">
        <?php if ($error): ?>
            <div class="alerta-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alerta-exito"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="POST" class="ajustes-form">
            <label>Nombre:
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required>
            </label>
            <label>Email:
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
            </label>
            <button type="submit" class="btn">Guardar cambios</button>
        </form>
        <div class="ajustes-links">
            <a href="landing.php" class="btn">Volver a inicio</a>
        </div>
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