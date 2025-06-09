<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
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
        <h1>Gestión de Usuarios</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none;">
                <li><a class="btn" href="/app/cultural-events-app/src/vistas/admin/dashboard.php">Panel Admin</a></li>
                <li><a class="btn" href="/app/cultural-events-app/src/controladores/eventos.controller.php">Eventos</a></li>
                <li><a class="btn" href="/app/cultural-events-app/src/vistas/landing.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
    <main class="usuarios-container">
        <h2>Usuarios registrados</h2>
        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th style="width: 120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td>
                            <?php if ($usuario['rol'] === 'usuario'): ?>
                                <a class="btn btn-editar" href="../../src/controladores/editarusuario.controller.php?id=<?php echo $usuario['id_usuario']; ?>">Editar</a>
                            <?php else: ?>
                                <!-- Puedes dejar vacío o poner un icono de admin -->
                                <span style="color:#888;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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