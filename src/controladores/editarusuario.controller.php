<?php
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header('Location: ../vistas/landing.php');
        exit;
    }

    require_once '../modelos/class.usuarios.php';
    require_once '../../config/conexion.php';

    $db = (new bd())->getConn();
    $usuariosModel = new Usuarios($db);

    $error = '';
    $success = '';
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header('Location: usuarios.controller.php');
        exit;
    }

    $usuario = $usuariosModel->obtenerUsuario($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre_usuario'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $rol = $_POST['rol'] ?? '';

        if ($usuariosModel->actualizarUsuarioAdmin($id, $nombre, $correo, $rol)) {
            $success = "Usuario actualizado correctamente.";
            $usuario = $usuariosModel->obtenerUsuario($id); // Recarga datos
        } else {
            $error = "Error al actualizar el usuario.";
        }
    }

    include '../vistas/admin/editarusuario.php';
?>