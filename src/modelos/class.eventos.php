<?php

    require_once('../../config/conexion.php');
class Eventos {
    private $bd;
    private $id_evento;
    private $nombre_evento;
    private $descripcion;
    private $id_categoria;
    private $fecha_hora;
    private $ubicacion;
    private $precio;
    private $aforo_max;
    private $aforo_dispo;

    public function __construct() {
        $this->bd = new bd();
        $this->id_evento = 0;
        $this->nombre_evento = '';
        $this->descripcion = '';
        $this->id_categoria = 0;
        $this->fecha_hora = '';
        $this->ubicacion = '';
        $this->precio = 0.0;
        $this->aforo_max = 0;
        $this->aforo_dispo = 0;
    }

    public function getConn() {
        return $this->bd->getConn();
    }

    public function crearEvento($titulo, $descripcion, $id_categoria, $fecha, $ubicacion, $precio, $aforo_max, $aforo_dispo) {
        $sql = "INSERT INTO events (nombre_evento, descripcion, id_categoria, fecha_hora, ubicacion, precio, aforo_max, aforo_dispo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->bd->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(
                "ssissdii",
                $titulo,
                $descripcion,
                $id_categoria,
                $fecha,
                $ubicacion,
                $precio,
                $aforo_max,
                $aforo_dispo
            );
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            return false;
        }
    }

    public function buscarEventos($where = [], $params = [], $types = '') {
        if ($where) {
            $sql = "SELECT e.*, c.nombre_categoria 
                    FROM events e
                    LEFT JOIN categorias c ON e.id_categoria = c.id_categoria
                    WHERE " . implode(' AND ', $where) . "
                    ORDER BY e.fecha_hora DESC";
            $stmt = $this->bd->getConn()->prepare($sql);
            if ($params) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $resultado = $stmt->get_result();
            $eventos = [];
            while ($row = $resultado->fetch_assoc()) {
                $eventos[] = $row;
            }
            $stmt->close();
            return $eventos;
        } else {
            return $this->listarEventos();
        }
    }

        public function actualizarEvento($id, $titulo, $descripcion, $id_categoria, $fecha, $ubicacion, $precio, $aforo_max, $aforo_dispo) {
        $sql = "UPDATE events SET nombre_evento=?, descripcion=?, id_categoria=?, fecha_hora=?, ubicacion=?, precio=?, aforo_max=?, aforo_dispo=?
                WHERE id_evento=?";
        $stmt = $this->bd->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(
                "ssissdiii",
                $titulo,
                $descripcion,
                $id_categoria,
                $fecha,
                $ubicacion,
                $precio,
                $aforo_max,
                $aforo_dispo,
                $id
            );
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
   

    public function obtenerEvento($id) {
        $sql = "SELECT e.*, c.nombre_categoria 
                FROM events e
                JOIN categorias c ON e.id_categoria = c.id_categoria
                WHERE e.id_evento = ?";
        $stmt = $this->bd->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $evento = $resultado->fetch_assoc();
            $stmt->close();
            return $evento;
        } else {
            return null;
        }
    }

    public function eliminarEvento($id) {
        $sql = "DELETE FROM events WHERE id_evento = ?";
        $stmt = $this->bd->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }

    public function cambiarCategoria($id_evento, $nueva_categoria) {
        $sql = "UPDATE events SET id_categoria = ? WHERE id_evento = ?";
        $stmt = $this->bd->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $nueva_categoria, $id_evento);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function listarEventos() {
        $sql = "SELECT e.*, c.nombre_categoria 
                FROM events e
                LEFT JOIN categorias c ON e.id_categoria = c.id_categoria
                ORDER BY e.fecha_hora DESC";
        $resultado = $this->bd->getConn()->query($sql);
        $eventos = [];
        while ($row = $resultado->fetch_assoc()) {
            $eventos[] = $row;
        }
        return $eventos;
    }
    public function listarEventosDestacados($limite = 6) {
        $sql = "SELECT * FROM events ORDER BY fecha_hora DESC LIMIT $limite";
        $stmt = $this->bd->getConn()->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $eventos = [];
        while ($row = $resultado->fetch_assoc()) {
            $eventos[] = $row;
        }
        $stmt->close();
        return $eventos;
    }

    public function obtenerTodasCategorias() {
        $sql = "SELECT * FROM categorias";
        $result = $this->bd->getConn()->query($sql);
        $categorias = [];
        while ($row = $result->fetch_assoc()) {
            $categorias[] = $row;
        }
        return $categorias;
    }

    public function obtenerPorCategoria($id_categoria) {
        $sql = "SELECT * FROM events WHERE id_categoria = ?";
        $stmt = $this->bd->getConn()->prepare($sql);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventos = [];
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
        return $eventos;
    }
}
?>