<?php
session_start();
require_once '../controladores/landing.controller.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio - CulturaGo</title>
    <link rel="stylesheet" href="../../public/assets/style.css">
</head>
<body>
    <?php if (isset($_SESSION['nombre'])): ?>
        <div class="usuario-info" style="position: absolute; top: 18px; right: 32px;">
            <a href="../controladores/ajustes.controller.php" style="text-decoration:none; color:white; font-weight:bold;">
                👤 <?= htmlspecialchars($_SESSION['nombre']); ?>
            </a>
        </div>
    <?php endif; ?>
    <header class="container" style="margin-bottom: 1rem;">
        <h1 style="text-align:center;">CulturaGo</h1>
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
                    <li><a class="btn" href="../../src/controladores/login.controller.php">Iniciar Sesión</a></li>
                    <li><a class="btn" href="../vistas/register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Mensaje de bienvenida personalizado -->
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <div class="bienvenida">
            👑 Bienvenido/a, <b><?= htmlspecialchars($_SESSION['nombre']) ?></b> (Administrador).<br>
            Gestiona eventos, usuarios y reservas desde tu panel.
        </div>
        <div class="acciones-rapidas">
            <a href="../vistas/admin/dashboard.php">Ir al Panel de Administración</a>
            <a href="../controladores/eventos.controller.php">Ver todos los eventos</a>
        </div>
    <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
        <div class="bienvenida">
            👋 ¡Hola, <b><?= htmlspecialchars($_SESSION['nombre']) ?></b>!<br>
            Descubre y reserva tus eventos favoritos.
        </div>
        <div class="acciones-rapidas">
            <a href="../controladores/eventos.controller.php">Explorar eventos</a>
            <a href="/app/cultural-events-app/src/vistas/misreservas.php">Mis reservas</a>
        </div>
    <?php else: ?>
        <div class="bienvenida">
            🎉 <b>Bienvenido/a a Cultural Events App</b><br>
            Regístrate gratis para descubrir y reservar los mejores eventos culturales de tu ciudad.
        </div>
        <div class="acciones-rapidas">
            <a href="../../src/controladores/login.controller.php">Iniciar Sesión</a>
            <a href="../vistas/register.php">Crear cuenta</a>
            <a href="../controladores/eventos.controller.php">Ver eventos</a>
        </div>
    <?php endif; ?>

    <main>
        <section class="container" style="margin-top: 1rem;">
            <h2 style="text-align:center;">Eventos Destacados</h2>
            <div class="carrusel-eventos">
                <button class="carrusel-btn carrusel-prev">&#8592;</button>
                <div class="carrusel-track">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <div class="event-card">
                                <h3><?= htmlspecialchars($event['nombre_evento']) ?></h3>
                                <p><strong>Fecha:</strong> <?= htmlspecialchars($event['fecha_hora']) ?></p>
                                <p><?= htmlspecialchars($event['descripcion']) ?></p>
                                <a class="btn" href="../controladores/eventos.controller.php">Ver más</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding:2rem;">No hay eventos destacados por ahora.</div>
                    <?php endif; ?>
                </div>
                <button class="carrusel-btn carrusel-next">&#8594;</button>
            </div>
        </section>
        <section class="ventajas">
            <h2>¿Por qué usar Cultural Events App?</h2>
            <ul>
                <li>Reserva tus plazas en segundos</li>
                <li>Descubre eventos exclusivos y gratuitos</li>
                <li>Gestión fácil de tus reservas</li>
                <li>Panel de administración para organizadores</li>
            </ul>
        </section>
        <section class="about">
            <h2>Sobre la plataforma</h2>
            <p>
                Cultural Events App es tu puerta de entrada a la cultura local. Nuestro objetivo es acercar los mejores eventos a todos los públicos, con una experiencia sencilla, rápida y segura tanto para usuarios como para organizadores.
            </p>
        </section>
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
    <script>
    // Carrusel simple para eventos destacados
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.carrusel-track');
        const cards = document.querySelectorAll('.event-card');
        const prevBtn = document.querySelector('.carrusel-prev');
        const nextBtn = document.querySelector('.carrusel-next');
        let index = 0;
        const visible = 1; // Cambia a 2 o 3 para mostrar más eventos a la vez

        function updateCarrusel() {
            cards.forEach((card, i) => {
                card.style.display = (i >= index && i < index + visible) ? 'block' : 'none';
            });
        }
        if (cards.length > visible) {
            prevBtn.style.display = nextBtn.style.display = 'block';
        } else {
            prevBtn.style.display = nextBtn.style.display = 'none';
        }
        prevBtn.addEventListener('click', () => {
            if (index > 0) index--;
            updateCarrusel();
        });
        nextBtn.addEventListener('click', () => {
            if (index < cards.length - visible) index++;
            updateCarrusel();
        });
        updateCarrusel();
    });
    </script>
</body>
</html>