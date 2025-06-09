<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
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
    <header>
        <h1>Gestión de Categorías</h1>
        <nav>
            <ul>
                <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <li><a class="btn" href="../vistas/landing.php">Inicio</a></li>
                <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main class="container" style="margin-top:2rem;">
        <h2>Categorías y eventos asociados</h2>
        <?php foreach ($categorias as $cat): ?>
            <div class="categoria-card">
                <h3><?= htmlspecialchars($cat['nombre_categoria']) ?></h3>
                <?php if (!empty($eventosPorCategoria[$cat['id_categoria']])): ?>
                    <table class="admin-cat-table">
                        <tr>
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>Cambiar a otra categoría</th>
                        </tr>
                        <?php foreach ($eventosPorCategoria[$cat['id_categoria']] as $evento): ?>
                            <tr>
                                <td><?= htmlspecialchars($evento['nombre_evento']) ?></td>
                                <td><?= htmlspecialchars($evento['fecha_hora']) ?></td>
                                <td>
                                    <form method="POST" action="../controladores/categoria.controller.php" style="display:inline;">
                                        <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                                        <select name="nueva_categoria">
                                            <?php foreach ($categorias as $c): ?>
                                                <option value="<?= $c['id_categoria'] ?>" <?= $c['id_categoria'] == $cat['id_categoria'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($c['nombre_categoria']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-editar">Cambiar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p style="color:#888;">No hay eventos en esta categoría.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
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