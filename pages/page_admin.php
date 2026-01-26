<?php
session_start();
require_once '../connection/db_pdo.inc';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: ../sessions/login.php');
    exit;
}

$nombre = $_SESSION['nombre'];
$email  = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin | Villa Canina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="../public/css/style-app.css">
</head>
<body>

<!--BOTÓN DESPLEGAR MENU EN MÓVIL -->
<nav class="navbar bg-header d-md-none">
    <div class="container-fluid">
        <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            ☰
        </button>
    </div>
</nav>

<div class="d-flex">
    <!--SIDEBAR PARA ORDENADORES-->
    <nav class="sidebar bg-header d-none d-md-block min-vh-100 p-3">
        <div class="text-center mb-4">
            <h2>Villa Canina</h2>
            <p class="fw-bold"><?= htmlspecialchars($nombre) ?></p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="page_admin.php" class="boton-verde">Inicio</a></li>
            <li class="nav-item mb-2"><a href="../app/controller/control_usuarios.php" class="boton-verde">Usuarios</a></li>
            <li class="nav-item mb-2"><a href="../app/controller/control_mascotas.php" class="boton-verde">Mascotas</a></li>
            <li class="nav-item mb-2"><a href=".../app/controller/control_solicitudes.php" class="boton-verde">Solicitudes</a></li>
            <li class="nav-item mb-2"><a href="../app/controller/control_citas.php" class="boton-verde">Citas</a></li>
            <li class="nav-item mb-2"><a href="../app/controller/control_donaciones.php" class="boton-verde">Donaciones</a></li>
            <li class="nav-item mb-2"><a href="../app/controller/control_productos.php" class="boton-verde">Productos</a></li>
            <li class="nav-item mt-4"><a href="../sessions/logout.php" class="boton-cerrar">Cerrar sesión</a></li>
        </ul>
    </nav>

    <!--OFFCANVAS SIDEBAR PARA MÓVIL-->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header">
            <div class="perfil">
                <h3 class="offcanvas-title">Villa Canina</h3>
                <p class="fw-bold"><?= htmlspecialchars($nombre) ?></p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-4">
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="page_admin.php" class="boton-verde">Inicio</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_usuarios.php" class="boton-verde">Usuarios</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_mascotas.php" class="boton-verde">Mascotas</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_solicitudes.php" class="boton-verde">Solicitudes</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_citas.php" class="boton-verde">Citas</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_donaciones.php" class="boton-verde">Donaciones</a></li>
                <li class="nav-item mb-2"><a href="../app/controller/control_productos.php" class="boton-verde">Productos</a></li>
                <li class="nav-item mt-4"><a href="../sessions/logout.php" class="boton-cerrar">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>

    <!--CONTENIDO PRINCIPAL-->
    <main class="flex-grow-1 p-4">
        <h1 class="mb-4">Bienvenido al Panel de Administración de Villa Canina</h1>
        <p>Selecciona una opción del menú lateral para gestionar la base de datos.</p>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
