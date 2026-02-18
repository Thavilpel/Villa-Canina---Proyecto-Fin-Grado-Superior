<?php
    session_start();

    // Verificar si hay sesión iniciada
    if (isset($_SESSION['id'])) {
        $nombre = $_SESSION['nombre'];
        $avatar = $_SESSION['avatar'] ?? 'default.png';
    }
?>