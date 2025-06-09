<?php
class Reservas {
    private $db;
    private $id_usuario;
    private $id_evento;
    private $cantidad;
    private $fecha_reserva;

    public function __construct($db) {
        $this->db = $db;
        $this->id_usuario = 0;
        $this->id_evento = 0;
        $this->cantidad = 0;
        $this->fecha_reserva = '';
    }

    public function obtenerReservasUsuario($id_usuario) {
        $sql = "SELECT r.*, e.nombre_evento, e.fecha_hora, e.ubicacion
                FROM reservas r
                JOIN events e ON r.id_evento = e.id_evento
                WHERE r.id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $reservas = [];
        while ($row = $resultado->fetch_assoc()) {
            $reservas[] = $row;
        }
        $stmt->close();
        return $reservas;
    }

    public function reservarEvento($id_usuario, $id_evento, $cantidad) {
        // Obtener aforo disponible
        $sql = "SELECT aforo_dispo FROM events WHERE id_evento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_evento);
        $aforo_dispo = null;
        $stmt->execute();
        $stmt->bind_result($aforo_dispo);
        $found = $stmt->fetch();
        $stmt->close();

        if ($found && $aforo_dispo !== null && $aforo_dispo >= $cantidad && $cantidad > 0) {
            // Comprobar si ya existe una reserva para este usuario y evento
            $sql = "SELECT cantidad FROM reservas WHERE id_usuario = ? AND id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $id_usuario, $id_evento);
            $stmt->execute();
            $stmt->bind_result($cantidad_existente);
            $existe = $stmt->fetch();
            $stmt->close();

            if ($existe) {
                // Si existe, suma la cantidad
                $nueva_cantidad = $cantidad_existente + $cantidad;
                $sql = "UPDATE reservas SET cantidad = ?, fecha_reserva = NOW() WHERE id_usuario = ? AND id_evento = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iii", $nueva_cantidad, $id_usuario, $id_evento);
                $stmt->execute();
                $stmt->close();
            } else {
                // Si no existe, inserta nueva reserva
                $sql = "INSERT INTO reservas (id_usuario, id_evento, cantidad, fecha_reserva) VALUES (?, ?, ?, NOW())";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iii", $id_usuario, $id_evento, $cantidad);
                $stmt->execute();
                $stmt->close();
            }

            // Actualizar aforo
            $nuevo_aforo = $aforo_dispo - $cantidad;
            $sql = "UPDATE events SET aforo_dispo = ? WHERE id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $nuevo_aforo, $id_evento);
            $stmt->execute();
            $stmt->close();

            return true;
        }
        return false;
    }

    public function obtenerTodasReservas() {
        $sql = "SELECT r.*, u.nombre_usuario, u.correo, e.nombre_evento
                FROM reservas r
                JOIN usuarios u ON r.id_usuario = u.id_usuario
                JOIN events e ON r.id_evento = e.id_evento
                ORDER BY r.fecha_reserva DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $reservas = [];
        while ($row = $resultado->fetch_assoc()) {
            $reservas[] = $row;
        }
        $stmt->close();
        return $reservas;
    }

    public function borrarReserva($id_usuario, $id_evento) {
        // Recuperar cantidad para devolver aforo
        $sql = "SELECT cantidad FROM reservas WHERE id_usuario = ? AND id_evento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_evento);
        $stmt->execute();
        $stmt->bind_result($cantidad);
        $found = $stmt->fetch();
        $stmt->close();

        if ($found) {
            // Borrar reserva
            $sql = "DELETE FROM reservas WHERE id_usuario = ? AND id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $id_usuario, $id_evento);
            $stmt->execute();
            $stmt->close();

            // Devolver aforo
            $sql = "UPDATE events SET aforo_dispo = aforo_dispo + ? WHERE id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $cantidad, $id_evento);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function editarCantidadReserva($id_usuario, $id_evento, $nueva_cantidad) {
        // Obtener la cantidad actual
        $sql = "SELECT cantidad FROM reservas WHERE id_usuario = ? AND id_evento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_evento);
        $stmt->execute();
        $stmt->bind_result($cantidad_actual);
        $found = $stmt->fetch();
        $stmt->close();

        if ($found) {
            // Obtener aforo disponible actual
            $sql = "SELECT aforo_dispo FROM events WHERE id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id_evento);
            $stmt->execute();
            $stmt->bind_result($aforo_dispo);
            $stmt->fetch();
            $stmt->close();

            $diferencia = $nueva_cantidad - $cantidad_actual;
            // Si diferencia > 0, hay que restar del aforo; si < 0, hay que sumar al aforo
            $nuevo_aforo = $aforo_dispo - $diferencia;

            if ($nuevo_aforo < 0) return false; // No hay suficiente aforo

            // Actualizar reserva
            $sql = "UPDATE reservas SET cantidad = ? WHERE id_usuario = ? AND id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iii", $nueva_cantidad, $id_usuario, $id_evento);
            $stmt->execute();
            $stmt->close();

            // Actualizar aforo
            $sql = "UPDATE events SET aforo_dispo = ? WHERE id_evento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $nuevo_aforo, $id_evento);
            $stmt->execute();
            $stmt->close();

            return true;
        }
        return false;
    }
    
}
?>