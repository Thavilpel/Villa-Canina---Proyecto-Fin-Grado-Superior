<?php
    session_start();

    // ==== SEGURIDAD: SOLO ADMIN ====
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
        header('Location: ../../sessions/login.php');
        exit;
    }

    // ==== CONEXIÓN Y MODELO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';
    require_once __DIR__ . '/../model/gestion_donaciones.php';

    $nombreAdmin = $_SESSION['nombre'] ?? '';
    $mensaje = "";

    // ==== FILTROS ====
    $nombre_buscar = $_GET['nombre_buscar'] ?? '';
    $orden = $_GET['orden'] ?? '';

    $filtros = [];
    if ($nombre_buscar !== '') {
        $filtros['nombre'] = $nombre_buscar;
    }
    if ($orden !== '') {
        $filtros['orden'] = $orden;
    }

    // ==== OBTENER DONACIONES FILTRADAS ====
    $donaciones = Donacion::obtenerTodas($filtros);

    // ==== CARGAR VISTA ====
    require __DIR__ . '/../view/donaciones.php';
?>