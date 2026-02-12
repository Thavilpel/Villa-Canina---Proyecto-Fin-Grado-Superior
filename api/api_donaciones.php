<?php
// ==== API REST ==== 

    // Encabezado: devuelve JSON
    header('Content-Type: application/json');

    // Incluir Modelo Donaciones
    require_once __DIR__ . '/../app/model/donacion.php';

    try {
        // Obtener todas las donaciones
        $donaciones = Donacion::obtenerTodas();

        // Devolver en JSON
        echo json_encode($donaciones);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>

