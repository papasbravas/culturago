<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../vistas/landing.php');
    exit;
}
require_once '../modelos/class.eventos.php';
require_once '../../config/conexion.php';

$bd = new bd();
$conn = $bd->getConn();
$eventosModel = new Eventos($conn);

// Procesar cambio de categoría (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'], $_POST['nueva_categoria'])) {
    $id_evento = intval($_POST['id_evento']);
    $nueva_categoria = intval($_POST['nueva_categoria']);
    $eventosModel->cambiarCategoria($id_evento, $nueva_categoria);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Mostrar gestión de categorías (GET)
$categorias = $eventosModel->obtenerTodasCategorias();
$eventosPorCategoria = [];
foreach ($categorias as $cat) {
    $eventosPorCategoria[$cat['id_categoria']] = $eventosModel->obtenerPorCategoria($cat['id_categoria']);
}

include '../vistas/admin/categorias.php';
?>