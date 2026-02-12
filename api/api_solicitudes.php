<?php
// ==== API REST ====

    // Encabezado: devuelve JSON
    header('Content-Type: application/json');

    // Incluir Modelo Solicitudes
    require_once __DIR__ . '/../app/model/solicitud.php';

    try {
        // Obtener todas las solicitudes
        $solicitudes = Solicitud::obtenerTodas();
        
        // Devolver en JSON
        echo json_encode($solicitudes);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
