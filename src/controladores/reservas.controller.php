<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../modelos/class.reservas.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $conn = $bd->getConn();
    $id_usuario = $_SESSION['id_usuario'] ?? null;

    $reservasModel = new Reservas($conn);

    // Procesar reserva
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'], $_POST['cantidad']) && $id_usuario) {
        $id_evento = intval($_POST['id_evento']);
        $cantidad = intval($_POST['cantidad']);

        $ok = $reservasModel->reservarEvento($id_usuario, $id_evento, $cantidad);

        if ($ok) {
            header('Location: ../controladores/eventos.controller.php?reserva=ok');
        } else {
            header('Location: ../controladores/eventos.controller.php?error=aforo');
        }
        exit;
    }

    // Obtener reservas del usuario para la vista "Mis reservas"
    if ($id_usuario) {
        $reservas = $reservasModel->obtenerReservasUsuario($id_usuario);
    } else {
        $reservas = [];
    }

    if (basename($_SERVER['SCRIPT_FILENAME']) === 'reservas.controller.php') {
        include '../vistas/misreservas.php';
    }
?>