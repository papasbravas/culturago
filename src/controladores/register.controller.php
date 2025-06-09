<?php
    session_start();
    require_once '../modelos/class.usuarios.php';
    require_once '../../config/conexion.php';

    $bd = new bd();
    $conn = $bd->getConn();
    $usuariosModel = new Usuarios($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        // Validación básica
        if ($nombre === '' || $email === '' || $contrasena === '') {
            header('Location: ../vistas/register.php?error=Completa todos los campos');
            exit;
        }

        // Comprobar si el email ya existe
        $existe = $usuariosModel->autenticar($email, $contrasena);
        if ($existe) {
            header('Location: ../vistas/register.php?error=El email ya está registrado');
            exit;
        }

        // Crear usuario
        $ok = $usuariosModel->crearUsuario($nombre, $email, $contrasena);
        if ($ok) {
            header('Location: login.controller.php?registro=ok');
            exit;
        } else {
            header('Location: ../vistas/register.php?error=No se pudo crear el usuario');
            exit;
        }
    } else {
        header('Location: ../vistas/register.php');
        exit;
    }
?>