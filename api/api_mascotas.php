<?php
// ==== API REST ==== 

    // Encabezado: devuelve JSON
    header('Content-Type: application/json');

    // Incluir Modelo Mascota
    require_once __DIR__ . '/../app/model/gestion_mascotas.php';

    try{
        // Obtener todas las mascotas
        $mascotas = Mascota::obtenerTodas();

        // Devolver en JSON
        echo json_encode($mascotas);

    } catch (Exception $e){
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>