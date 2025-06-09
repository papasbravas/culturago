<?php
    session_start();
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: login.php');
        exit;
    }
    require_once '../modelos/class.usuarios.php';
    require_once '../../config/conexion.php';

    $db = (new bd())->getConn();
    $usuariosModel = new Usuarios($db);

    $usuario = $usuariosModel->obtenerUsuario($_SESSION['id_usuario']);

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuevo_nombre = $_POST['nombre'] ?? '';
        $nuevo_email = $_POST['email'] ?? '';
        
        if ($usuariosModel->actualizarUsuario($_SESSION['id_usuario'], $nuevo_nombre, $nuevo_email)) {
            $success = "Datos actualizados correctamente.";
            $_SESSION['nombre'] = $nuevo_nombre;
            $usuario = $usuariosModel->obtenerUsuario($_SESSION['id_usuario']);
        } else {
            $error = "Error al actualizar los datos.";
        }
    }
    include '../vistas/ajustes.php';
?>