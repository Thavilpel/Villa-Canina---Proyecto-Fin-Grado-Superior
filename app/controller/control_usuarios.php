<?php
    session_start();

    // ==== SEGURIDAD: SOLO ADMIN ====
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
        header('Location: ../../sessions/login.php');
        exit;
    }

    // ==== CONEXIÓN Y MODELO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';
    require_once __DIR__ . '/../model/gestion_usuarios.php';

    $mensaje = "";
    $nombreAdmin = $_SESSION['nombre'] ?? '';

    // ==== FILTROS ====
    $nombre_buscar = $_GET['nombre_buscar'] ?? '';
    $id_buscar     = $_GET['id_buscar'] ?? '';

    $filtros = [];
    if ($nombre_buscar !== '') {
        $filtros['nombre'] = $nombre_buscar;
    }
    if ($id_buscar !== '') {
        $filtros['id'] = $id_buscar;
    }

    // ==== ACCIONES ====
    $action = $_GET['action'] ?? 'index';

        // CREAR USUARIO
        if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = Usuario::crear($_POST);
            $mensaje = $ok ? "✅ Usuario creado correctamente" : "⚠️ Este email ya existe, elige otro.";
            header("Location: control_usuarios.php");
            exit;
        }

        // EDITAR USUARIO
        if ($action === 'editar' && (isset($_GET['id']) || $_SERVER['REQUEST_METHOD'] === 'POST')) {
            $id = $_POST['id'] ?? $_GET['id'];
            $usuario = Usuario::obtenerPorId((int)$id);

            if (!$usuario) {
                header("Location: control_usuarios.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;
                if (empty($data['password'])) {
                    unset($data['password']);
                }

                $ok = Usuario::actualizar((int)$id, $data);
                $mensaje = $ok ? "✅ Usuario actualizado correctamente" : "⚠️ Este email ya existe, elige otro.";
                header("Location: control_usuarios.php");
                exit;
            }
        }

        // ELIMINAR USUARIO
        if ($action === 'eliminar' && isset($_GET['id'])) {
            Usuario::eliminar((int)$_GET['id']);
            header("Location: control_usuarios.php");
            exit;
        }

    // ==== OBTENER USUARIOS FILTRADOS ====
    $usuarios = Usuario::obtenerTodos($filtros);

    // ==== CARGAR VISTA ====
    require __DIR__ . '/../view/usuarios.php';
?>
