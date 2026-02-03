<?php
    // ==== CONEXIÓN PDO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';

    class Usuario {

        // ==== OBTENER TODOS LOS USUARIOS ====
        public static function obtenerTodos($filtros = []) {
            global $pdo;

            $sql = "SELECT u.*, r.nombre AS rol
                    FROM usuarios u
                    JOIN roles r ON u.rol_id = r.id";
            $params = [];
            $condiciones = [];

            // Filtro por nombre o apellido
            if (!empty($filtros['nombre'])) {
                $condiciones[] = "(u.nombre LIKE ? OR u.apellidos LIKE ?)";
                $params[] = "%".$filtros['nombre']."%";
                $params[] = "%".$filtros['nombre']."%";
            }

            // Filtro por ID
            if (!empty($filtros['id'])) {
                $condiciones[] = "u.id = ?";
                $params[] = $filtros['id'];
            }

            if ($condiciones) {
                $sql .= " WHERE " . implode(" AND ", $condiciones);
            }

            $sql .= " ORDER BY u.id DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }

        // ==== OBTENER UN USUARIO POR ID ====
        public static function obtenerPorId($id) {
            global $pdo;

            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetch();
        }

        // ==== CREAR USUARIO ====
        public static function crear($datos) {
            global $pdo;

            // Comprobar si el email ya existe
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $check->execute([$datos['email']]);
            if ($check->rowCount() > 0) return false;

            $sql = "INSERT INTO usuarios
                    (nombre, apellidos, email, password, rol_id, telefono, direccion, ciudad, provincia)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            return $stmt->execute([
                $datos['nombre'],
                $datos['apellidos'],
                $datos['email'],
                password_hash($datos['password'], PASSWORD_DEFAULT),
                $datos['rol_id'],
                $datos['telefono'] ?? '',
                $datos['direccion'] ?? '',
                $datos['ciudad'] ?? '',
                $datos['provincia'] ?? ''
            ]);
        }

        // ==== ACTUALIZAR USUARIO ====
        public static function actualizar($id, $datos) {
            global $pdo;

            // Comprobar si el email ya existe en otro usuario
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $check->execute([$datos['email'], $id]);
            if ($check->rowCount() > 0) return false;

            // Preparar contraseña si se envía
            if (!empty($datos['password'])) {
                $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET
                            nombre = ?, apellidos = ?, email = ?, password = ?, rol_id = ?,
                            telefono = ?, direccion = ?, ciudad = ?, provincia = ?
                        WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                return $stmt->execute([
                    $datos['nombre'],
                    $datos['apellidos'],
                    $datos['email'],
                    $datos['password'],
                    $datos['rol_id'],
                    $datos['telefono'] ?? '',
                    $datos['direccion'] ?? '',
                    $datos['ciudad'] ?? '',
                    $datos['provincia'] ?? '',
                    $id
                ]);
            } else {
                // Sin actualizar contraseña
                $sql = "UPDATE usuarios SET
                            nombre = ?, apellidos = ?, email = ?, rol_id = ?,
                            telefono = ?, direccion = ?, ciudad = ?, provincia = ?
                        WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                return $stmt->execute([
                    $datos['nombre'],
                    $datos['apellidos'],
                    $datos['email'],
                    $datos['rol_id'],
                    $datos['telefono'] ?? '',
                    $datos['direccion'] ?? '',
                    $datos['ciudad'] ?? '',
                    $datos['provincia'] ?? '',
                    $id
                ]);
            }
        }

        // ==== ELIMINAR USUARIO ====
        public static function eliminar($id) {
            global $pdo;

            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
?>
