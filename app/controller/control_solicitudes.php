<?php
session_start();

// ==== Seguridad: solo admin ====
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: ../sessions/login.php');
    exit;
}

// ==== CONEXIÓN Y MODELO ====
require_once __DIR__ . '/../../connection/db_pdo.inc';
require_once __DIR__ . '/../model/gestion_solicitudes.php';

$nombreAdmin = $_SESSION['nombre'] ?? 'Admin';
$mensaje = $_GET['mensaje'] ?? "";

// ==== ACCIONES ====

// ELIMINAR SOLICITUD
if (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['id'])) {
    $res = Solicitud::eliminar((int)$_GET['id']);
    $mensaje = $res ? "✅ Solicitud eliminada correctamente." : "⚠️ No se pudo eliminar la solicitud.";
    header("Location: control_solicitudes.php?mensaje=" . urlencode($mensaje));
    exit;
}

// CREAR CITA
if (isset($_GET['action']) && $_GET['action'] === 'crear_cita' && isset($_POST['solicitud_id'], $_POST['fecha_hora'])) {
    $solicitud_id = (int)$_POST['solicitud_id'];
    $fecha_hora   = $_POST['fecha_hora'];
    $comentario   = $_POST['comentario'] ?? null;

    // Crear cita
    $res = Solicitud::crearCita($solicitud_id, $fecha_hora, $comentario);

    // Marcar que la solicitud tiene cita
    if ($res) {
        $stmt = $pdo->prepare("UPDATE solicitudes SET tiene_cita = 1 WHERE id = ?");
        $stmt->execute([$solicitud_id]);
    }

    $mensaje = $res ? "✅ Cita creada correctamente." : "⚠️ Error al crear la cita.";
    header("Location: control_solicitudes.php?mensaje=" . urlencode($mensaje));
    exit;
}

// ==== FILTROS Y ORDEN ====
$usuario_buscar = $_GET['usuario_buscar'] ?? '';
$servicio_id    = $_GET['servicio_id'] ?? '';
$orden_fecha    = strtoupper($_GET['orden_fecha'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';
$tiene_cita = $_GET['tiene_cita'] ?? '';

// ==== CARGAR DATOS ====
$servicios    = Solicitud::obtenerServicios();
$solicitudes = Solicitud::obtenerTodas($orden_fecha, $usuario_buscar, $servicio_id, $tiene_cita);

// ==== CARGAR VISTA ====
require __DIR__ . '/../view/solicitudes.php';
?>
