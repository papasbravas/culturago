<?php
session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header('Location: ../vistas/landing.php');
        exit;
    }

    require_once '../modelos/class.reservas.php';
    require_once '../modelos/class.usuarios.php';
    require_once '../modelos/class.eventos.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $conn = $bd->getConn();
    $reservasModel = new Reservas($conn);

    // Borrar reserva si se solicita
    if (isset($_GET['borrar']) && isset($_GET['id_usuario']) && isset($_GET['id_evento'])) {
        $reservasModel->borrarReserva($_GET['id_usuario'], $_GET['id_evento']);
        header('Location: reservasadmin.controller.php?borrado=ok');
        exit;
    }
    
    $editar_reserva = null;
    if (isset($_GET['editar'], $_GET['id_usuario'], $_GET['id_evento'], $_GET['cantidad'])) {
        $editar_reserva = [
            'id_usuario' => $_GET['id_usuario'],
            'id_evento' => $_GET['id_evento'],
            'cantidad' => $_GET['cantidad']
        ];
    }
    if (isset($_POST['guardar_edicion'], $_POST['id_usuario'], $_POST['id_evento'], $_POST['nueva_cantidad'])) {
        $id_usuario = intval($_POST['id_usuario']);
        $id_evento = intval($_POST['id_evento']);
        $nueva_cantidad = intval($_POST['nueva_cantidad']);
        $reservasModel->editarCantidadReserva($id_usuario, $id_evento, $nueva_cantidad);
        header('Location: reservasadmin.controller.php');
        exit;
    }
    // Obtener todas las reservas con datos de usuario y evento
    $reservas = $reservasModel->obtenerTodasReservas();

    include '../vistas/admin/reservasadmin.php';
?>