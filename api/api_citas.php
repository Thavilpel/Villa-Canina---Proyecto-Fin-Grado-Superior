<?php
// ==== API REST ==== 

    // Encabezado: devuelve JSON
    header('Content-Type: application/json');

    // Incluir Modelo Citas
    require_once __DIR__ . '/../app/model/gestion_citas.php';

    try {
        // Obtener todas las citas
        $citas = Cita::obtenerTodas();

        // Devolver en JSON
        echo json_encode($citas);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
