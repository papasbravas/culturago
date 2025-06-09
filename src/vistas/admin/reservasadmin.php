<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas de Usuarios</title>
    <link rel="stylesheet" href="/app/cultural-events-app/public/assets/style.css">
</head>
<body>
    <?php if (isset($_SESSION['nombre'])): ?>
        <div class="usuario-info" style="position: absolute; top: 18px; right: 32px;">
            <a href="../controladores/ajustes.controller.php" style="text-decoration:none; color:white; font-weight:bold;">
                👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?>
            </a>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <header>
        <h1>Reservas Usuarios</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <li><a class="btn" href="../vistas/landing.php">Inicio</a></li>
                <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main class="usuarios-container">
        <h2>Listado de reservas</h2>
        <?php if (isset($_GET['borrado']) && $_GET['borrado'] === 'ok'): ?>
            <div class="alerta-exito">Reserva eliminada correctamente.</div>
        <?php endif; ?>
        <?php if ($editar_reserva): ?>
            <form method="post" action="reservasadmin.controller.php" class="form-editar-reserva" style="margin-bottom:20px;">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($editar_reserva['id_usuario']) ?>">
                <input type="hidden" name="id_evento" value="<?= htmlspecialchars($editar_reserva['id_evento']) ?>">
                <label>
                    Nueva cantidad:
                    <input type="number" name="nueva_cantidad" min="0" max="<?= htmlspecialchars($editar_reserva['cantidad']) ?>" value="<?= htmlspecialchars($editar_reserva['cantidad']) ?>" required>
                </label>
                <button type="submit" name="guardar_edicion" class="btn btn-editar">Guardar</button>
                <a href="reservasadmin.controller.php" class="btn">Cancelar</a>
            </form>
        <?php endif; ?>
        <?php if (count($reservas) > 0): ?>
            <table class="usuarios-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Evento</th>
                        <th>Cantidad</th>
                        <th>Fecha de reserva</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['nombre_usuario']) ?></td>
                            <td><?= htmlspecialchars($reserva['correo']) ?></td>
                            <td><?= htmlspecialchars($reserva['nombre_evento']) ?></td>
                            <td><?= htmlspecialchars($reserva['cantidad']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                            <td>
                                <a class="btn btn-editar" href="reservasadmin.controller.php?borrar=1&id_usuario=<?= $reserva['id_usuario'] ?>&id_evento=<?= $reserva['id_evento'] ?>" onclick="return confirm('¿Seguro que quieres borrar esta reserva?');">Borrar</a>
                                <a class="btn btn-editar" href="reservasadmin.controller.php?editar=1&id_usuario=<?= $reserva['id_usuario'] ?>&id_evento=<?= $reserva['id_evento'] ?>&cantidad=<?= $reserva['cantidad'] ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay reservas registradas.</p>
        <?php endif; ?>
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