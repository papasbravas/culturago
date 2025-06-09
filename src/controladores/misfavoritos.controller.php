<?php
    session_start();
    require_once '../modelos/class.favoritos.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $conn = $bd->getConn();
    $favoritosModel = new Favoritos($conn);

    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $favoritos = $id_usuario ? $favoritosModel->obtenerFavoritosUsuario($id_usuario) : [];

    include '../vistas/misfavoritos.php';
?>