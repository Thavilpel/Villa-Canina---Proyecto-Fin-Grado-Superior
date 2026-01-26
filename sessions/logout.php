<?php
// Iniciamos la sesión
session_start();

// Limpiamos todas las variables de sesión
$_SESSION = [];

// Destruimos la sesión
session_destroy();

// Redirigimos a la página principal)
header("Location: ../index.php"); 
exit;
?>
