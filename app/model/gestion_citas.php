<?php
// ==== CONEXIÓN PDO ====
require_once __DIR__ . '/../../connection/db_pdo.inc';

class Cita {

    // ==== OBTENER TODAS LAS CITAS ====
    public static function obtenerTodas($usuario_buscar = '', $estado_cita = '', $orden_fecha = 'DESC', $servicio_id = '') {
        global $pdo;

        $sql = "SELECT c.id, c.solicitud_id, u.nombre AS nombre_usuario, u.apellidos AS apellidos_usuario,
                    u.email, u.telefono, c.fecha_hora, c.estado, c.comentario,
                    s.servicio_id, sv.nombre AS servicio
                FROM citas c
                INNER JOIN solicitudes s ON c.solicitud_id = s.id
                INNER JOIN usuarios u ON s.usuario_id = u.id
                LEFT JOIN servicios sv ON s.servicio_id = sv.id
                WHERE 1=1";

        $params = [];

        if (!empty($usuario_buscar)) {
            $sql .= " AND (u.nombre LIKE :usuario OR u.apellidos LIKE :usuario)";
            $params[':usuario'] = "%$usuario_buscar%";
        }

        if (!empty($estado_cita)) {
            $sql .= " AND c.estado = :estado";
            $params[':estado'] = $estado_cita;
        }

        if (!empty($servicio_id)) {
            $sql .= " AND s.servicio_id = :servicio_id";
            $params[':servicio_id'] = $servicio_id;
        }

        $sql .= " ORDER BY c.fecha_hora " . ($orden_fecha === 'ASC' ? 'ASC' : 'DESC');

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==== OBTENER CITA POR ID ====
    public static function obtenerPorId($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM citas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==== CREAR CITA ====
    public static function crear($data) {
        global $pdo;
        $sql = "INSERT INTO citas (solicitud_id, fecha_hora, estado, comentario) 
                VALUES (:solicitud_id, :fecha_hora, :estado, :comentario)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':solicitud_id' => $data['solicitud_id'] ?? null,
            ':fecha_hora'   => $data['fecha_hora'],
            ':estado'       => $data['estado'],
            ':comentario'   => $data['comentario'] ?? ''
        ]);
    }

    //// ==== EDITAR CITAS ====
    public static function editar($id, $data) {
        global $pdo;
        $sql = "UPDATE citas 
                SET fecha_hora = :fecha_hora, 
                    comentario = :comentario, 
                    estado = :estado 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fecha_hora' => $data['fecha_hora'],
            ':comentario' => $data['comentario'] ?? '',
            ':estado'     => $data['estado'],
            ':id'         => $id
        ]);
    }

    // // ==== ELIMINAR CITAS Y SOLICITUDES ASOCIADAS ====
    public static function eliminar($id) {
        global $pdo;

        // Obtener cita antes de eliminar
        $cita = self::obtenerPorId($id);
        if ($cita) {
            // Eliminar la solicitud asociada
            if (!empty($cita['solicitud_id'])) {
                $stmt = $pdo->prepare("DELETE FROM solicitudes WHERE id = :id");
                $stmt->execute([':id' => $cita['solicitud_id']]);
            }

            // Eliminar la cita
            $stmt = $pdo->prepare("DELETE FROM citas WHERE id = :id");
            $stmt->execute([':id' => $id]);
        }
    }
}
