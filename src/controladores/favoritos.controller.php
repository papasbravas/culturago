<?php
    session_start();
    require_once '../modelos/class.favoritos.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $conn = $bd->getConn();
    $favoritosModel = new Favoritos($conn);

    $id_usuario = $_SESSION['id_usuario'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_usuario) {
        $id_evento = intval($_POST['id_evento']);
        if (isset($_POST['agregar_favorito'])) {
            $favoritosModel->agregarFavorito($id_usuario, $id_evento);
        } elseif (isset($_POST['quitar_favorito'])) {
            $favoritosModel->quitarFavorito($id_usuario, $id_evento);
        }
    }
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../vistas/eventos.php'));
    exit;
?>