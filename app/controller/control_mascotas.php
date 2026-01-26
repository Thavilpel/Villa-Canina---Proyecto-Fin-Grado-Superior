<?php
session_start();

// ==== SEGURIDAD: SOLO ADMIN ====
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: ../sessions/login.php');
    exit;
}

// ==== CARGAR CONEXIÓN Y MODELO ====
require_once __DIR__ . '/../../connection/db_pdo.inc';
require_once __DIR__ . '/../model/gestion_mascotas.php';

class MascotaController {

    private $mensaje = "";
    private $nombreAdmin;

    public function __construct() {
        $this->nombreAdmin = $_SESSION['nombre'] ?? '';
    }

    // ==== LISTAR MASCOTAS CON FILTROS ====
    public function index() {
        global $pdo;

        $id_buscar = $_GET['id_buscar'] ?? null;
        $filtroEstado = $_GET['estado'] ?? null;

        if ($id_buscar) {
            $stmt = $pdo->prepare("SELECT m.*,
                                        u.id AS usuario_id,
                                        u.nombre AS usuario_nombre,
                                        u.email AS usuario_email,
                                        um.fecha_adopcion
                                    FROM mascotas m
                                    LEFT JOIN usuarios_mascotas um ON m.id = um.mascota_id
                                    LEFT JOIN usuarios u ON um.usuario_id = u.id
                                    WHERE m.id = ?
                                    ORDER BY m.id DESC");
            $stmt->execute([$id_buscar]);
            $mascotas = $stmt->fetchAll();
        } elseif ($filtroEstado) {
            $stmt = $pdo->prepare("SELECT m.*,
                                        u.id AS usuario_id,
                                        u.nombre AS usuario_nombre,
                                        u.email AS usuario_email,
                                        um.fecha_adopcion
                                    FROM mascotas m
                                    LEFT JOIN usuarios_mascotas um ON m.id = um.mascota_id
                                    LEFT JOIN usuarios u ON um.usuario_id = u.id
                                    WHERE m.estado = ?
                                    ORDER BY m.id DESC");
            $stmt->execute([$filtroEstado]);
            $mascotas = $stmt->fetchAll();
        } else {
            $mascotas = Mascota::obtenerTodas();
        }

        $usuarios = Mascota::obtenerUsuarios();
        $mensaje = $this->mensaje;
        $nombreAdmin = $this->nombreAdmin;

        require __DIR__ . '/../view/mascotas.php';
    }

    // ==== CREAR MASCOTA ====
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = [
                'nombre' => $_POST['nombre'],
                'raza' => $_POST['raza'] ?? null,
                'genero' => $_POST['genero'],
                'edad' => $_POST['edad'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'estado' => $_POST['estado'],
                'imagen' => $_POST['imagen'] ?? 'default.png',
                'usuario_id' => $_POST['usuario_id'] ?? null,
                'fecha_adopcion' => date('Y-m-d')
            ];

            if ($datos['estado'] === 'adoptado' && empty($datos['usuario_id'])) {
                $this->mensaje = "⚠️ Debes seleccionar un usuario antes de marcar la mascota como adoptada.";
            } else {
                $ok = Mascota::crear($datos);
                $this->mensaje = $ok ? "✅ Mascota creada correctamente" : "⚠️ Error al crear la mascota";
            }

            header("Location: control_mascotas.php?action=index");
            exit;
        }
    }

    // ==== EDITAR MASCOTA ====
    public function editar() {
        if (!isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: control_mascotas.php?action=index");
            exit;
        }

        $id = $_POST['id'] ?? (int) $_GET['id'];
        $mascota = Mascota::obtenerPorId($id);

        if (!$mascota) {
            header("Location: control_mascotas.php?action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => $_POST['nombre'],
                'raza' => $_POST['raza'] ?? null,
                'genero' => $_POST['genero'],
                'edad' => $_POST['edad'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'estado' => $_POST['estado'],
                'imagen' => $_POST['imagen'] ?? $mascota['imagen'],
                'usuario_id' => $_POST['usuario_id'] ?? null,
                'fecha_adopcion' => date('Y-m-d')
            ];

            if ($datos['estado'] === 'adoptado' && empty($datos['usuario_id'])) {
                $this->mensaje = "⚠️ Debes seleccionar un usuario antes de marcar la mascota como adoptada.";
            } else {
                $ok = Mascota::actualizar($id, $datos);
                $this->mensaje = $ok ? "✅ Mascota actualizada correctamente" : "⚠️ Error al actualizar la mascota";
            }

            header("Location: control_mascotas.php?action=index");
            exit;
        }
    }

    // ==== ELIMINAR MASCOTA ====
    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            try {
                Mascota::eliminar($id);
                $this->mensaje = "✅ Mascota eliminada correctamente";
            } catch (PDOException $e) {
                $this->mensaje = "⚠️ No se puede eliminar la mascota, tiene adopciones registradas.";
            }
        }

        header("Location: control_mascotas.php?action=index");
        exit;
    }
}

// ==== RUTEO DE ACCIONES ====
$controller = new MascotaController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'crear':
        $controller->crear();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'eliminar':
        $controller->eliminar();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
?>
