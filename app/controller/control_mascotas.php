<?php
    session_start();

    // ==== SEGURIDAD: SOLO ADMIN ====
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
        header('Location: ../../sessions/login.php');
        exit;
    }

    // ==== CONEXIÓN Y MODELO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';
    require_once __DIR__ . '/../model/gestion_mascotas.php';

    $mensaje = "";
    $nombreAdmin = $_SESSION['nombre'] ?? '';

    // ==== FILTROS ====
    $id_buscar = $_GET['id_buscar'] ?? '';
    $filtro_estado = $_GET['estado'] ?? '';

    $filtros = [];
    if ($id_buscar !== '') {
        $filtros['id'] = $id_buscar;
    }
    if ($filtro_estado !== '') {
        $filtros['estado'] = $filtro_estado;
    }

    // ==== ACCIONES ====
    $action = $_GET['action'] ?? 'index';

        // ==== CREAR MASCOTA ====
        if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'      => $_POST['nombre'] ?? '',
                'raza'        => $_POST['raza'] ?? null,
                'genero'      => $_POST['genero'] ?? '',
                'edad'        => $_POST['edad'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'estado'      => $_POST['estado'] ?? 'disponible',
                'imagen'      => $_POST['imagen'] ?? 'default.png',
                'usuario_id'  => $_POST['usuario_id'] ?? null,
                'fecha_adopcion' => date('Y-m-d')
            ];

            if ($datos['estado'] === 'adoptado' && empty($datos['usuario_id'])) {
                $mensaje = "⚠️ Debes seleccionar un usuario antes de marcar la mascota como adoptada.";
            } else {
                $ok = Mascota::crear($datos);
                $mensaje = $ok ? "✅ Mascota creada correctamente" : "⚠️ Error al crear la mascota";
            }

            header("Location: control_mascotas.php");
            exit;
        }

        // ==== EDITAR MASCOTA ====
        if ($action === 'editar' && (isset($_GET['id']) || $_SERVER['REQUEST_METHOD'] === 'POST')) {
            $id = $_POST['id'] ?? $_GET['id'];
            $mascota = Mascota::obtenerPorId((int)$id);

            if (!$mascota) {
                header("Location: control_mascotas.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $datos = [
                    'nombre'      => $_POST['nombre'] ?? $mascota['nombre'],
                    'raza'        => $_POST['raza'] ?? $mascota['raza'],
                    'genero'      => $_POST['genero'] ?? $mascota['genero'],
                    'edad'        => $_POST['edad'] ?? $mascota['edad'],
                    'descripcion' => $_POST['descripcion'] ?? $mascota['descripcion'],
                    'estado'      => $_POST['estado'] ?? $mascota['estado'],
                    'imagen'      => $_POST['imagen'] ?? $mascota['imagen'],
                    'usuario_id'  => $_POST['usuario_id'] ?? $mascota['usuario_id'],
                    'fecha_adopcion' => date('Y-m-d')
                ];

                if ($datos['estado'] === 'adoptado' && empty($datos['usuario_id'])) {
                    $mensaje = "⚠️ Debes seleccionar un usuario antes de marcar la mascota como adoptada.";
                } else {
                    $ok = Mascota::actualizar((int)$id, $datos);
                    $mensaje = $ok ? "✅ Mascota actualizada correctamente" : "⚠️ Error al actualizar la mascota";
                }

                header("Location: control_mascotas.php");
                exit;
            }
        }

        // ==== ELIMINAR MASCOTA ====
        if ($action === 'eliminar' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            try {
                Mascota::eliminar($id);
                $mensaje = "✅ Mascota eliminada correctamente";
            } catch (PDOException $e) {
                $mensaje = "⚠️ No se puede eliminar la mascota, tiene adopciones registradas.";
            }
            header("Location: control_mascotas.php");
            exit;
        }

    // ==== OBTENER MASCOTAS FILTRADAS ====
    $mascotas = Mascota::obtenerTodas($filtros);
    $usuarios = Mascota::obtenerUsuarios();

    // ==== CARGAR VISTA ====
    require __DIR__ . '/../view/mascotas.php';
?>
