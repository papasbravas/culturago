<?php
class Usuarios {
    private $db;
    private $id_usu;
    private $nombre_usu;
    private $correo;
    private $contra;
    private $rol;

    public function __construct($db) {
        $this->db = $db;
        $this->id_usu = 0;
        $this->nombre_usu = '';
        $this->correo = '';
        $this->contra = '';
        $this->rol = 'usuario';
    }

    public function crearUsuario($nombre, $email, $contrasena) {
        $sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasenna, rol) VALUES (?, ?, ?, 'usuario')";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $nombre, $email, $contrasena);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    public function autenticar($email, $contrasenna) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = $resultado->fetch_assoc();
            $stmt->close();
            if ($usuario && $contrasenna === $usuario['contrasenna']) {
                return $usuario;
            }
        }
        return false;
    }

    public function actualizarUsuario($id, $nombre, $email) {
        $sql = "UPDATE usuarios SET nombre_usuario = ?, correo = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssi", $nombre, $email, $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    public function obtenerUsuario($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = $resultado->fetch_assoc();
            $stmt->close();
            return $usuario;
        }
        return false;
    }

    public function eliminarUsuario($id) {
        // Código para eliminar un usuario de la base de datos
    }

    public function listarUsuarios() {
        $sql = "SELECT id_usuario, nombre_usuario, correo, rol FROM usuarios";
        $resultado = $this->db->query($sql);
        $usuarios = [];
        while ($row = $resultado->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    public function actualizarUsuarioAdmin($id, $nombre, $correo, $rol) {
        $sql = "UPDATE usuarios SET nombre_usuario=?, correo=?, rol=? WHERE id_usuario=?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssi", $nombre, $correo, $rol, $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
}
?>