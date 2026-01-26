<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: ../sessions/login.php');
    exit;
}

require_once __DIR__ . '/../../connection/db_pdo.inc';
require_once __DIR__ . '/../model/gestion_citas.php';

$nombreAdmin = $_SESSION['nombre'] ?? '';
$mensaje = $_GET['mensaje'] ?? '';

// Capturar filtros
$usuario_buscar = $_GET['usuario_buscar'] ?? '';
$estado_cita = $_GET['estado_cita'] ?? '';
$orden_fecha = $_GET['orden_fecha'] ?? 'DESC';
$servicio_id = $_GET['servicio_id'] ?? '';

// Acciones: crear, editar, eliminar
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'eliminar' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Obtener la cita antes de eliminar
    $cita = Cita::obtenerPorId($id);

    if ($cita) {
        // Si la cita tiene solicitud asociada, eliminarla
        if (!empty($cita['solicitud_id'])) {
            $solicitudId = (int)$cita['solicitud_id'];
            $stmt = $pdo->prepare("DELETE FROM solicitudes WHERE id = :id");
            $stmt->execute([':id' => $solicitudId]);
        }

        // Eliminar la cita
        Cita::eliminar($id);

        header('Location: control_citas.php?mensaje=Cita y solicitud asociada eliminadas correctamente');
        exit;
    } else {
        header('Location: control_citas.php?mensaje=La cita no existe');
        exit;
    }
}

if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'solicitud_id' => $_POST['solicitud_id'] ?? null,
        'fecha_hora'   => $_POST['fecha_hora'],
        'estado'       => $_POST['estado'],
        'comentario'   => $_POST['comentario'] ?? ''
    ];
    Cita::crear($data);
    header('Location: control_citas.php?mensaje=Cita creada correctamente');
    exit;
}

if ($action === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $data = [
        'fecha_hora' => $_POST['fecha_hora'],
        'comentario' => $_POST['comentario'] ?? '',
        'estado'     => $_POST['estado']
    ];
    Cita::editar($id, $data);
    header('Location: control_citas.php?mensaje=Cita actualizada correctamente');
    exit;
}

// Obtener todos los servicios para el filtro
$stmt = $pdo->query("SELECT id, nombre FROM servicios ORDER BY nombre ASC");
$servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener todas las citas con filtros
$citas = Cita::obtenerTodas($usuario_buscar, $estado_cita, $orden_fecha, $servicio_id);

// Cargar vista
require __DIR__ . '/../view/citas.php';
