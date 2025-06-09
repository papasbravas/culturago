<?php
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header('Location: ../vistas/landing.php');
        exit;
    }

    require_once '../modelos/class.usuarios.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $usuariosModel = new Usuarios($bd->getConn());
    $usuarios = $usuariosModel->listarUsuarios();

    include '../vistas/admin/usuarios.php';
?>