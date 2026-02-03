<?php
    // ==== CONEXIÓN PDO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';

    class Mascota {

        // ==== OBTENER TODAS LAS MASCOTAS CON INFO DE ADOPCIÓN ====
        public static function obtenerTodas($filtros = []) {
            global $pdo;

            $sql = "SELECT m.*,
                        u.id AS usuario_id,
                        u.nombre AS usuario_nombre,
                        u.email AS usuario_email,
                        um.fecha_adopcion
                    FROM mascotas m
                    LEFT JOIN usuarios_mascotas um ON m.id = um.mascota_id
                    LEFT JOIN usuarios u ON um.usuario_id = u.id";
            
            $conditions = [];
            $params = [];

            if (!empty($filtros['id'])) {
                $conditions[] = "m.id = ?";
                $params[] = $filtros['id'];
            }

            if (!empty($filtros['estado'])) {
                $conditions[] = "m.estado = ?";
                $params[] = $filtros['estado'];
            }

            if ($conditions) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " ORDER BY m.id DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }

        // ==== OBTENER UNA MASCOTA POR ID ====
        public static function obtenerPorId($id) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM mascotas WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        // ==== OBTENER TODOS LOS USUARIOS ====
        public static function obtenerUsuarios() {
            global $pdo;
            $stmt = $pdo->query("SELECT id, nombre, email FROM usuarios ORDER BY nombre ASC");
            return $stmt->fetchAll();
        }

        // ==== CREAR MASCOTA ====
        public static function crear($datos) {
            global $pdo;

            $sql = "INSERT INTO mascotas (nombre, raza, genero, edad, descripcion, estado, imagen)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            $ok = $stmt->execute([
                $datos['nombre'],
                $datos['raza'] ?? null,
                $datos['genero'] ?? 'M',
                $datos['edad'] ?? null,
                $datos['descripcion'] ?? null,
                $datos['estado'] ?? 'disponible',
                $datos['imagen'] ?? 'default.png'
            ]);

            // Registrar adopción
            if ($ok && ($datos['estado'] ?? 'disponible') === 'adoptado' && !empty($datos['usuario_id'])) {
                self::registrarAdopcion($pdo->lastInsertId(), $datos['usuario_id'], $datos['fecha_adopcion'] ?? date('Y-m-d'));
            }

            return $ok;
        }

        // ==== ACTUALIZAR MASCOTA ====
        public static function actualizar($id, $datos) {
            global $pdo;

            // Actualizar datos principales
            $sql = "UPDATE mascotas SET
                        nombre = ?, raza = ?, genero = ?, edad = ?, descripcion = ?, estado = ?, imagen = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                $datos['nombre'],
                $datos['raza'] ?? null,
                $datos['genero'] ?? 'M',
                $datos['edad'] ?? null,
                $datos['descripcion'] ?? null,
                $datos['estado'] ?? 'disponible',
                $datos['imagen'] ?? 'default.png',
                $id
            ]);

            if (!$ok) return false;

            // Gestionar adopción
            if (($datos['estado'] ?? 'disponible') === 'adoptado' && !empty($datos['usuario_id'])) {
                self::registrarAdopcion($id, $datos['usuario_id'], $datos['fecha_adopcion'] ?? date('Y-m-d'));
            } elseif (($datos['estado'] ?? 'disponible') === 'disponible') {
                self::eliminarAdopcion($id);
            }

            return true;
        }

        // ==== ELIMINAR MASCOTA ====
        public static function eliminar($id) {
            global $pdo;

            self::eliminarAdopcion($id);

            $stmt = $pdo->prepare("DELETE FROM mascotas WHERE id = ?");
            return $stmt->execute([$id]);
        }

        // ==== REGISTRAR ADOPCIÓN ====
        private static function registrarAdopcion($mascota_id, $usuario_id, $fecha) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT id FROM usuarios_mascotas WHERE mascota_id = ?");
            $stmt->execute([$mascota_id]);
            if ($stmt->fetch()) {
                $stmt2 = $pdo->prepare("UPDATE usuarios_mascotas SET usuario_id = ?, fecha_adopcion = ? WHERE mascota_id = ?");
                $stmt2->execute([$usuario_id, $fecha, $mascota_id]);
            } else {
                $stmt2 = $pdo->prepare("INSERT INTO usuarios_mascotas (usuario_id, mascota_id, fecha_adopcion) VALUES (?, ?, ?)");
                $stmt2->execute([$usuario_id, $mascota_id, $fecha]);
            }
        }

        // ==== ELIMINAR ADOPCIÓN ====
        private static function eliminarAdopcion($mascota_id) {
            global $pdo;
            $stmt = $pdo->prepare("DELETE FROM usuarios_mascotas WHERE mascota_id = ?");
            $stmt->execute([$mascota_id]);
        }
    }
?>
