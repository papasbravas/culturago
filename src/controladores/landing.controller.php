<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../modelos/class.eventos.php';
    require_once '../../config/conexion.php';

    // No pases $db al constructor
    $eventosModel = new Eventos();
    $events = $eventosModel->listarEventosDestacados();
?>