<?php
    // ==== CONEXIÓN PDO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';

    class Donacion {

        // ==== OBTENER TODAS LAS DONACIONES ====
        public static function obtenerTodas($filtros = []) {
            global $pdo;

            $sql = "SELECT d.id,
                        u.nombre,
                        u.apellidos,
                        u.email,
                        u.telefono,
                        d.cantidad,
                        d.fecha
                    FROM donaciones d
                    JOIN usuarios u ON d.usuario_id = u.id";

            $condiciones = [];
            $params = [];

            // Filtro por nombre o apellido
            if (!empty($filtros['nombre'])) {
                $condiciones[] = "(u.nombre LIKE ? OR u.apellidos LIKE ?)";
                $params[] = "%{$filtros['nombre']}%";
                $params[] = "%{$filtros['nombre']}%";
            }

            if ($condiciones) {
                $sql .= " WHERE " . implode(" AND ", $condiciones);
            }

            // Orden
            if (!empty($filtros['orden']) && $filtros['orden'] === 'cantidad_desc') {
                $sql .= " ORDER BY d.cantidad DESC";
            } else {
                $sql .= " ORDER BY d.fecha DESC";
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }
    }
?>