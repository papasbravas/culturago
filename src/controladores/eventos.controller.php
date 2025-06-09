<?php
session_start();
require_once '../modelos/class.eventos.php';

$eventosModel = new Eventos();

$mensaje = '';
$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// --- PROCESAR EDICIÓN DE EVENTO ---
if ($esAdmin && isset($_POST['editar_evento'])) {
    $id = $_POST['id_evento'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $id_categoria = $_POST['id_categoria'];
    $fecha = $_POST['fecha'];
    $ubicacion = $_POST['ubicacion'];
    $precio = $_POST['precio'];
    $aforo_max = $_POST['aforo_max'];
    $aforo_dispo = $_POST['aforo_dispo'];

    $editado = $eventosModel->actualizarEvento($id, $titulo, $descripcion, $id_categoria, $fecha, $ubicacion, $precio, $aforo_max, $aforo_dispo);
    if ($editado) {
        $mensaje = "Evento editado correctamente.";
    } else {
        $mensaje = "Error al editar el evento.";
    }
}
// --- PROCESAR CREACIÓN DE EVENTO ---
elseif ($esAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $id_categoria = $_POST['id_categoria'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $aforo_max = $_POST['aforo_max'] ?? 0;
    $aforo_dispo = $_POST['aforo_dispo'] ?? 0;

    $creado = $eventosModel->crearEvento($titulo, $descripcion, $id_categoria, $fecha, $ubicacion, $precio, $aforo_max, $aforo_dispo);

    if ($creado) {
        $mensaje = "Evento creado correctamente.";
    } else {
        $mensaje = "Error al crear el evento.";
    }
}

// --- FILTROS DE BÚSQUEDA ---
$where = [];
$params = [];
$types = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $where[] = 'e.id_evento = ?';
    $params[] = (int)$_GET['id'];
    $types .= 'i';
}
if (!empty($_GET['nombre'])) {
    $where[] = 'e.nombre_evento LIKE ?';
    $params[] = '%' . $_GET['nombre'] . '%';
    $types .= 's';
}
if (!empty($_GET['categoria'])) {
    $where[] = 'c.nombre_categoria = ?';
    $params[] = $_GET['categoria'];
    $types .= 's';
}

$eventos = $eventosModel->buscarEventos($where, $params, $types);

// --- FORMULARIO DE EDICIÓN ---
$eventoEditar = null;
if ($esAdmin && isset($_GET['editar'])) {
    $eventoEditar = $eventosModel->obtenerEvento($_GET['editar']);
}

// --- ELIMINAR EVENTO ---
if ($esAdmin && isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $eliminado = $eventosModel->eliminarEvento($id);
    if ($eliminado) {
        $mensaje = "Evento eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el evento.";
    }
    header("Location: eventos.controller.php?mensaje=" . urlencode($mensaje));
    exit;
}

include '../vistas/eventos.php';
?>