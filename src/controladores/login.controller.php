<?php
    session_start();
    require_once '../modelos/class.usuarios.php';
    require_once '../../config/conexion.php';

    $db = (new bd())->getConn();
    $usuariosModel = new Usuarios($db);

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';
        $usuario = $usuariosModel->autenticar($email, $contrasena);
        // var_dump($usuario);
        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['nombre'] = $usuario['nombre_usuario']; // Usa el nombre correcto del campo
            header('Location: ../vistas/landing.php');
            exit;
        } else {
            $error = 'Credenciales incorrectas';
        }
    }

    include '../vistas/login.php';
?>