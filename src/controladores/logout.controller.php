<?php
    session_start();
    session_unset(); // Limpia todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header('Location: ../vistas/landing.php'); // Redirige al login
    exit;
?>