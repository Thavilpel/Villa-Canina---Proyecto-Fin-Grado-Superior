<?php
require_once __DIR__ . '/../../connection/db_pdo.inc';

class Solicitud {

    public static function obtenerTodas($ordenFecha = 'DESC', $usuario = '', $servicio_id = '', $tiene_cita = '') {
        global $pdo;
        $params = [];

        $sql = "SELECT 
                    s.id,
                    s.telefono,
                    s.email,
                    s.fecha_solicitud,
                    s.descripcion,
                    u.nombre AS nombre_usuario,
                    u.apellidos AS apellidos_usuario,
                    srv.nombre AS servicio,
                    s.tiene_cita
                FROM solicitudes s
                INNER JOIN usuarios u ON s.usuario_id = u.id
                INNER JOIN servicios srv ON s.servicio_id = srv.id
                WHERE 1=1";

        // Filtro por usuario
        if (!empty($usuario)) {
            $palabras = preg_split('/\s+/', trim($usuario));
            foreach ($palabras as $palabra) {
                $sql .= " AND (u.nombre LIKE ? OR u.apellidos LIKE ?)";
                $params[] = "%" . $palabra . "%";
                $params[] = "%" . $palabra . "%";
            }
        }

        // Filtro por servicio
        if (!empty($servicio_id)) {
            $sql .= " AND s.servicio_id = ?";
            $params[] = $servicio_id;
        }

        // Filtro por cita
        if ($tiene_cita === '1' || $tiene_cita === '0') {
            $sql .= " AND s.tiene_cita = ?";
            $params[] = $tiene_cita;
        }

        // Orden por fecha
        $orden = ($ordenFecha === 'ASC') ? 'ASC' : 'DESC';
        $sql .= " ORDER BY s.fecha_solicitud $orden";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function obtenerServicios() {
        global $pdo;
        $stmt = $pdo->query("SELECT id, nombre FROM servicios ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function eliminar($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM solicitudes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function crearCita($solicitud_id, $fecha_hora, $comentario = null) {
        global $pdo;

        // Verificar si ya tiene cita
        $stmtCheck = $pdo->prepare("SELECT tiene_cita FROM solicitudes WHERE id = ?");
        $stmtCheck->execute([$solicitud_id]);
        $solicitud = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($solicitud && $solicitud['tiene_cita']) {
            return false; // ya tiene cita
        }

        // Crear cita
        $sql = "INSERT INTO citas (solicitud_id, fecha_hora, comentario) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $res = $stmt->execute([$solicitud_id, $fecha_hora, $comentario]);

        if ($res) {
            // Marcar la solicitud como que ya tiene cita
            $pdo->prepare("UPDATE solicitudes SET tiene_cita = 1 WHERE id = ?")->execute([$solicitud_id]);
        }

        return $res;
    }

    public static function crear($data) {
        global $pdo;

        $sql = "INSERT INTO solicitudes 
                (usuario_id, servicio_id, telefono, email, descripcion, fecha_solicitud)
                VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            $data['usuario_id'],
            $data['servicio_id'],
            $data['telefono'],
            $data['email'],
            $data['descripcion']
        ]);
    }
}
