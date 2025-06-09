<?php
    session_start();
    require_once '../controladores/reservas.controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
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
        <h1 style="text-align:center;">Zona de Reservas</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="logout.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                    <li><a class="btn" href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="reservas-container">
        <h2>Reservas realizadas</h2>
        <?php if (count($reservas) > 0): ?>
            <table class="reservas-table">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Cantidad</th>
                        <th>Fecha de reserva</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['nombre_evento']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_hora']) ?></td>
                            <td><?= htmlspecialchars($reserva['ubicacion']) ?></td>
                            <td><?= htmlspecialchars($reserva['cantidad']) ?></td>
                            <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes reservas aún.</p>
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