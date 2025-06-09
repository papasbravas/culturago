<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../vistas/landing.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../../public/assets/style.css">
    <style>
        .admin-dashboard-welcome {
            text-align: center;
            color: #35424a;
            font-size: 1.6em;
            margin: 2.5rem 0 1.5rem 0;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .admin-quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            margin: 2.5rem 0 2rem 0;
        }
        .admin-action-card {
            background: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 1px 8px rgba(53,66,74,0.07);
            padding: 2rem 2.2rem;
            min-width: 180px;
            text-align: center;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .admin-action-card:hover {
            box-shadow: 0 4px 18px rgba(53,66,74,0.13);
            transform: translateY(-4px) scale(1.03);
        }
        .admin-action-card .btn {
            margin-top: 1rem;
            width: 100%;
        }
        .admin-tips {
            background: #fffbe6;
            border-left: 5px solid #ffd700;
            border-radius: 8px;
            padding: 1.2rem 1.5rem;
            margin: 2rem auto 1.5rem auto;
            max-width: 600px;
            color: #555;
            font-size: 1.08em;
        }
        .admin-cita {
            text-align: center;
            font-style: italic;
            color: #6c7a89;
            margin: 2.5rem 0 1.5rem 0;
        }
        @media (max-width: 700px) {
            .admin-quick-actions { gap: 1rem; }
            .admin-action-card { padding: 1.2rem 0.5rem; min-width: 120px; }
        }
    </style>
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
        <h1 style="text-align:center;">Panel de Administración</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none;">
                <li><a class="btn" href="../../controladores/eventos.controller.php">Eventos</a></li>
                <li><a class="btn" href="../../vistas/landing.php">Inicio</a></li>
                <li><a class="btn" href="../../vistas/admin/dashboard.php">Panel Admin</a></li>
                <li><a class="btn" href="../../controladores/logout.controller.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <div class="admin-dashboard-welcome">
            Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Administrador'); ?>
        </div>
        <div class="admin-quick-actions">
            <div class="admin-action-card">
                <div style="font-size:2em;">🎫</div>
                <div>Gestionar Eventos</div>
                <a class="btn" href="../../controladores/eventos.controller.php">Ir</a>
            </div>
            <div class="admin-action-card">
                <div style="font-size:2em;">👥</div>
                <div>Gestionar Usuarios</div>
                <a class="btn" href="../../controladores/usuarios.controller.php">Ir</a>
            </div>
            <div class="admin-action-card">
                <div style="font-size:2em;">📝</div>
                <div>Gestionar Reservas</div>
                <a class="btn" href="../../controladores/reservasadmin.controller.php">Ir</a>
            </div>
            <div class="admin-action-card">
                <div style="font-size:2em;">📂</div>
                <div>Gestionar Categorías</div>
                <a class="btn" href="../../controladores/categoria.controller.php">Ir</a>
            </div>
        </div>
        <div class="admin-tips">
            <b>Consejos rápidos:</b>
            <ul style="margin: 0.5em 0 0 1.2em; padding: 0;">
                <li>Utiliza los accesos directos para gestionar cada sección.</li>
                <li>Recuerda revisar los eventos próximos y el aforo disponible.</li>
                <li>Puedes cambiar tu información desde el menú de usuario arriba a la derecha.</li>
            </ul>
        </div>
        <div class="admin-cita">
            “La cultura es el mejor viaje que uno puede hacer.”<br>
            <span>- Anónimo</span>
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