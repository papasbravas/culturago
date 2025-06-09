<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="/app/cultural-events-app/public/assets/style.css">
</head>
<body>
    <?php if (isset($_SESSION['nombre'])): ?>
        <div class="usuario-info" style="position: absolute; top: 18px; right: 32px;">
            <a href="../controladores/ajustes.controller.php" style="text-decoration:none; color:white; font-weight:bold;">
            👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </a>
        </div>
    <?php endif; ?>
    <header class="container" style="margin-bottom: 1rem;">
        <h1 style="text-align:center;">Bienvenido a la Aplicación de Eventos Culturales</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="logout.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                    <li><a class="btn" href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="usuarios-container">
        <h2>Editar Usuario</h2>
        <?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <?php if ($success): ?><p style="color:green;"><?= htmlspecialchars($success) ?></p><?php endif; ?>
        <form method="POST">
            <label for="nombre_usuario">Nombre:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required>
            <label for="correo">Email:</label>
            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="usuario" <?= $usuario['rol'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" class="btn btn-editar">Guardar Cambios</button>
            <a href="usuarios.controller.php" class="btn">Volver</a>
        </form>
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