<!-- Hacer que funcione lo de las reservas -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
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
        <h1 style="text-align:center;">Lista de eventos</h1>
        <nav>
            <ul style="display: flex; justify-content: center; gap: 2rem; list-style: none; margin-top: 1rem;">
                <li><a class="btn" href="../controladores/eventos.controller.php">Eventos</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a class="btn" href="../vistas/admin/dashboard.php">Panel Admin</a></li>
                    <li><a class="btn" href="../../src/vistas/landing.php">Inicio</a></li>
                    <li><a class="btn" href="../controladores/logout.controller.php">Cerrar Sesión</a></li>
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
    <main>
        <section class="eventos-container">
            <h2 style="text-align:center; margin-bottom:1.5rem;">
                <?php
                    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
                        echo "Gestión de Eventos";
                    } elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario') {
                        echo "Explora y Reserva tus Eventos";
                    } else {
                        echo "Eventos Disponibles";
                    }
                ?>
            </h2>
            <form method="GET" action="" class="eventos-busqueda">
                <?php if ($esAdmin): ?>
                    <input type="number" name="id" id="id" min="1" placeholder="ID de evento" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                <?php endif; ?>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del evento" value="<?php echo isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : ''; ?>">
                <input type="text" name="categoria" id="categoria" placeholder="Categoría" value="<?php echo isset($_GET['categoria']) ? htmlspecialchars($_GET['categoria']) : ''; ?>">
                <button type="submit">Buscar</button>
                <a href="eventos.controller.php" class="btn">Ver todos</a>
            </form>
            <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
                <div class="alerta-exito">¡Reserva realizada con éxito!</div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] === 'aforo'): ?>
                <div class="alerta-error">No hay plazas suficientes.</div>
            <?php endif; ?>

            <?php if ($esAdmin && $eventoEditar): ?>
                <section class="eventos-crear">
                    <h2>Editar Evento</h2>
                    <form action="eventos.controller.php" method="POST">
                        <input type="hidden" name="id_evento" value="<?= $eventoEditar['id_evento'] ?>">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($eventoEditar['nombre_evento']) ?>" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($eventoEditar['descripcion']) ?></textarea>

                        <label for="id_categoria">Categoría (ID):</label>
                        <input type="number" id="id_categoria" name="id_categoria" min="1" value="<?= htmlspecialchars($eventoEditar['id_categoria']) ?>" required>

                        <label for="fecha">Fecha y hora:</label>
                        <input type="datetime-local" id="fecha" name="fecha" value="<?= date('Y-m-d\TH:i', strtotime($eventoEditar['fecha_hora'])) ?>" required>

                        <label for="ubicacion">Ubicación:</label>
                        <input type="text" id="ubicacion" name="ubicacion" value="<?= htmlspecialchars($eventoEditar['ubicacion']) ?>" required>

                        <label for="precio">Precio:</label>
                        <input type="number" id="precio" name="precio" min="0" step="0.01" value="<?= htmlspecialchars($eventoEditar['precio']) ?>" required>

                        <label for="aforo_max">Aforo máximo:</label>
                        <input type="number" id="aforo_max" name="aforo_max" min="1" value="<?= htmlspecialchars($eventoEditar['aforo_max']) ?>" required>

                        <label for="aforo_dispo">Aforo disponible:</label>
                        <input type="number" id="aforo_dispo" name="aforo_dispo" min="0" value="<?= htmlspecialchars($eventoEditar['aforo_dispo']) ?>" required>

                        <button type="submit" name="editar_evento">Guardar Cambios</button>
                        <a href="eventos.controller.php" class="btn">Cancelar</a>
                    </form>
                </section>
            <?php endif; ?>
            <?php if (!empty($_GET['mensaje'])): ?>
                <div class="alerta-exito"><?= htmlspecialchars($_GET['mensaje']) ?></div>
            <?php endif; ?>
            <div class="eventos-grid">
                <?php foreach ($eventos as $evento): ?>
                    <div class="evento-card">
                        <h3><?php echo htmlspecialchars($evento['nombre_evento']); ?></h3>
                        <?php if (isset($_SESSION['id_usuario'])): ?>
                            <form method="post" action="../controladores/favoritos.controller.php" style="display:inline;">
                                <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
                                <?php if (in_array($evento['id_evento'], $favoritos ?? [])): ?>
                                    <button type="submit" name="quitar_favorito" class="favorito-btn favorito-activo" title="Quitar de favoritos">❤️</button>
                                <?php else: ?>
                                    <button type="submit" name="agregar_favorito" class="favorito-btn" title="Agregar a favoritos">🤍</button>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                        <p class="evento-desc"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($evento['fecha_hora']); ?></p>
                        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['nombre_categoria']); ?></p>
                        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion']); ?></p>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($evento['precio']); ?></p>
                        <p><strong>Disponibilidad:</strong> <?php echo htmlspecialchars($evento['aforo_dispo']); ?> / <?php echo htmlspecialchars($evento['aforo_max']); ?></p>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                            <?php if ($evento['aforo_dispo'] > 0): ?>
                                <form method="POST" action="../controladores/reservas.controller.php" class="evento-reserva-form">
                                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $evento['aforo_dispo']; ?>" style="width:60px;">
                                    <button type="submit" class="btn">Reservar</button>
                                </form>
                            <?php else: ?>
                                <span class="evento-sinplazas">Sin plazas</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($esAdmin): ?>
                            <div class="evento-admin">
                                <span class="evento-admin-label">Admin:</span>
                                <a href="eventos.controller.php?editar=<?= $evento['id_evento'] ?>" class="btn btn-editar">Editar</a>
                                <a href="eventos.controller.php?eliminar=<?= $evento['id_evento'] ?>" class="btn btn-editar" onclick="return confirm('¿Seguro que quieres eliminar este evento?');">Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($esAdmin): ?>
                <section class="eventos-crear">
                    <h2>Crear Evento</h2>
                    <form action="eventos.controller.php" method="POST">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" required></textarea>

                        <label for="id_categoria">Categoría (ID):</label>
                        <input type="number" id="id_categoria" name="id_categoria" min="1" required>

                        <label for="fecha">Fecha y hora:</label>
                        <input type="datetime-local" id="fecha" name="fecha" required>

                        <label for="ubicacion">Ubicación:</label>
                        <input type="text" id="ubicacion" name="ubicacion" required>

                        <label for="precio">Precio:</label>
                        <input type="number" id="precio" name="precio" min="0" step="0.01" required>

                        <label for="aforo_max">Aforo máximo:</label>
                        <input type="number" id="aforo_max" name="aforo_max" min="1" required>

                        <label for="aforo_dispo">Aforo disponible:</label>
                        <input type="number" id="aforo_dispo" name="aforo_dispo" min="0" required>

                        <button type="submit">Crear Evento</button>
                    </form>
                </section>
            <?php endif; ?>
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
</body>
</html>