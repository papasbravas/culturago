<?php
class Favoritos {
    private $db;
    private $id_usuario;
    private $id_evento;
    public function __construct($db) {
        $this->db = $db;
        $this->id_usuario = 0;
        $this->id_evento = 0;
    }

    public function agregarFavorito($id_usuario, $id_evento) {
        $sql = "INSERT IGNORE INTO favorita (id_usuario, id_evento) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_evento);
        return $stmt->execute();
    }

    public function quitarFavorito($id_usuario, $id_evento) {
        $sql = "DELETE FROM favorita WHERE id_usuario = ? AND id_evento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_evento);
        return $stmt->execute();
    }

    public function obtenerFavoritosUsuario($id_usuario) {
        $sql = "SELECT e.* FROM favorita f
                JOIN events e ON f.id_evento = e.id_evento
                WHERE f.id_usuario = ? AND e.fecha_hora > NOW()
                ORDER BY e.fecha_hora ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventos = [];
        while ($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
        return $eventos;
    }

    public function esFavorito($id_usuario, $id_evento) {
        $sql = "SELECT * FROM favorita WHERE id_usuario = ? AND id_evento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_evento);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
?>