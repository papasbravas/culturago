<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Favoritos</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
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
        <h1 style="text-align:center;">Lista de eventos favoritos</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="logout.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                    <a class="btn" href="../vistas/register.php">Registrarse</a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="eventos-container">
        <h2>Mis eventos favoritos</h2>
        <div class="eventos-grid">
            <?php foreach ($favoritos as $evento): ?>
                <div class="evento-card">
                    <h3><?= htmlspecialchars($evento['nombre_evento']) ?></h3>
                    <form method="post" action="../controladores/favoritos.controller.php" style="display:inline;">
                        <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                        <button type="submit" name="quitar_favorito" class="favorito-btn favorito-activo" title="Quitar de favoritos">❤️</button>
                    </form>
                    <p class="evento-desc"><?= htmlspecialchars($evento['descripcion']) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha_hora']) ?></p>
                    <p><strong>Categoría:</strong> <?= htmlspecialchars($evento['nombre_categoria'] ?? '') ?></p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($evento['ubicacion']) ?></p>
                    <p><strong>Disponibilidad:</strong> <?= htmlspecialchars($evento['aforo_dispo']) ?> / <?= htmlspecialchars($evento['aforo_max']) ?></p>
                </div>
            <?php endforeach; ?>
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