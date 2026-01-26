<?php
require_once __DIR__ . '/../../connection/db_pdo.inc';

class Mascota {

    // ==== OBTENER TODAS LAS MASCOTAS CON INFO DE ADOPCION ====
    public static function obtenerTodas() {
        global $pdo;

        $sql = "SELECT m.*,
                    u.id AS usuario_id,
                    u.nombre AS usuario_nombre,
                    u.email AS usuario_email,
                    um.fecha_adopcion
                FROM mascotas m
                LEFT JOIN usuarios_mascotas um ON m.id = um.mascota_id
                LEFT JOIN usuarios u ON um.usuario_id = u.id
                ORDER BY m.id DESC";

        return $pdo->query($sql)->fetchAll();
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

        $sql = "INSERT INTO mascotas
                (nombre, raza, genero, edad, descripcion, estado, imagen)
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

        // ==== Si está adoptado, registrar usuario y fecha ====
        if ($ok && ($datos['estado'] ?? 'disponible') === 'adoptado' && !empty($datos['usuario_id'])) {
            $fecha = $datos['fecha_adopcion'] ?? date('Y-m-d');
            $stmt2 = $pdo->prepare("INSERT INTO usuarios_mascotas (usuario_id, mascota_id, fecha_adopcion) VALUES (?, ?, ?)");
            $stmt2->execute([$datos['usuario_id'], $pdo->lastInsertId(), $fecha]);
        }

        return $ok;
    }

    // ==== ACTUALIZAR MASCOTA ====
    public static function actualizar($id, $datos) {
        global $pdo;

        // ==== Validación: si está adoptado, usuario_id es obligatorio ====
        if ($datos['estado'] === 'adoptado' && empty($datos['usuario_id'])) {
            return false; // No se puede actualizar
        }

        // ==== Actualizar datos de la mascota ====
        $sql = "UPDATE mascotas SET
                    nombre = ?,
                    raza = ?,
                    genero = ?,
                    edad = ?,
                    descripcion = ?,
                    estado = ?,
                    imagen = ?
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            $datos['nombre'],
            $datos['raza'],
            $datos['genero'],
            $datos['edad'],
            $datos['descripcion'],
            $datos['estado'],
            $datos['imagen'],
            $id
        ]);

        // ==== Gestionar adopción ====
        if ($ok && $datos['estado'] === 'adoptado') {
            // Insertar o actualizar adopción
            $stmt2 = $pdo->prepare("SELECT id FROM usuarios_mascotas WHERE mascota_id = ?");
            $stmt2->execute([$id]);
            if ($stmt2->fetch()) {
                // Si ya existe adopción, actualizar usuario y fecha
                $stmt3 = $pdo->prepare("UPDATE usuarios_mascotas SET usuario_id = ?, fecha_adopcion = ? WHERE mascota_id = ?");
                $stmt3->execute([$datos['usuario_id'], date('Y-m-d'), $id]);
            } else {
                // Insertar nueva adopción con fecha de hoy
                $stmt3 = $pdo->prepare("INSERT INTO usuarios_mascotas (usuario_id, mascota_id, fecha_adopcion) VALUES (?, ?, ?)");
                $stmt3->execute([$datos['usuario_id'], $id, date('Y-m-d')]);
            }
        }

        // ==== Si vuelve a disponible, eliminar adopción ====
        if ($ok && $datos['estado'] === 'disponible') {
            $stmt4 = $pdo->prepare("DELETE FROM usuarios_mascotas WHERE mascota_id = ?");
            $stmt4->execute([$id]);
        }

        return $ok;
    }

    // ==== ELIMINAR MASCOTA ====
    public static function eliminar($id) {
        
        global $pdo;

        // Borrar adopciones relacionadas
        $stmt1 = $pdo->prepare("DELETE FROM usuarios_mascotas WHERE mascota_id = ?");
        $stmt1->execute([$id]);

        // Borrar la mascota
        $stmt2 = $pdo->prepare("DELETE FROM mascotas WHERE id = ?");
        return $stmt2->execute([$id]);
    }

}
?>
