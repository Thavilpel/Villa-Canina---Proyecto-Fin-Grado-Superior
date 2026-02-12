<?php
session_start();

// Verificamos sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../sessions/login.php");
    exit;
}

// Solo usuarios normales (rol = 2)
if ($_SESSION['rol'] != 2) {
    if ($_SESSION['rol'] == 1) {
        header("Location: ../admin/clientes/gestion_clientes.php"); // admin
    } else {
        header("Location: ../sessions/login.php");
    }
    exit;
}

$nombre = $_SESSION['nombre'];
$avatar = $_SESSION['avatar'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Villa Canina - Animales</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Link css -->
<link rel="stylesheet" href="../public/css/style-index.css">

<!-- Fuente -->
<link href="https://fonts.googleapis.com/css2?family=Yrsa&display=swap" rel="stylesheet">

<!-- Logo -->
<link rel="icon" type="image/png" href="../public/img/web/logo.png">
</head>
<body>

<!-- HEADER -->
<header class="d-flex justify-content-between align-items-center flex-wrap">
    <section class="logotipo">
        <img src="../public/img/web/logo.png" alt="Logo">
        <h1>Villa Canina</h1>
    </section>

    <nav>
        <ul>
            <li><a href="#">Animales</a></li>
            <li><a href="#">Adopciones</a></li>
            <li><a href="page_formulario.php">Servicios</a></li>
            <li><a href="page_donaciones.php">Donaciones</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Sobre nosotros</a></li>
        </ul>
    </nav>

    <section class="usuario d-flex align-items-center gap-2">
        <div>
            <img src="../public/img/avatar/<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="rounded-circle" width="70" height="70">
            <span><?= htmlspecialchars($nombre) ?></span>
        </div>
        <a href="../sessions/logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </section>
</header>

<main class="container my-5">

    <!-- FILTROS DE ANIMALES -->
    <section class="mb-4">
        <h2 class="text-center mb-3">Filtrar Animales Disponibles</h2>
        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-3">
                <select id="filtro-sexo" class="form-select">
                    <option value="">Todos los sexos</option>
                    <option value="M">Macho</option>
                    <option value="F">Hembra</option>
                </select>
            </div>

            <div class="col-12 col-md-3">
                <select id="filtro-edad" class="form-select">
                    <option value="">Todas las edades</option>
                    <option value="0-1">Cachorro (0-1 año)</option>
                    <option value="1-3">Joven (1-3 años)</option>
                    <option value="3-7">Adulto (3-7 años)</option>
                    <option value="7+">Mayor (7+ años)</option>
                </select>
            </div>

            <div class="col-12 col-md-3">
                <input type="text" id="filtro-raza" class="form-control" placeholder="Buscar por raza">
            </div>
        </div>
    </section>

    <!-- LISTA DE MASCOTAS -->
    <section class="row" id="lista-mascotas">
        <!-- Aquí se cargarán las tarjetas de animales desde main.js -->
    </section>

</main>

<!-- FOOTER -->
<footer>
<section class="piePagina">
    <article>
        <div>
            <h1>VILLA CANINA</h1>
            <p>
                Villa Canina es un espacio dedicado al cuidado integral y bienestar de los perros. Aquí tu mascota encuentra atención veterinaria, alojamiento seguro, peluquería, tienda de productos y mucho cariño.
            </p>
            <p>
                &copy; 2026 Villa Canina. Todos los derechos reservados.
            </p>
        </div>

        <div>
            <h2>Servicios</h2>
            <ul>
                <li><a href="#">Adopción</a></li>
                <li><a href="#">Tienda</a></li>
                <li><a href="#">Peluquería</a></li>
                <li><a href="#">Veterinario</a></li>
                <li><a href="#">Alojamiento</a></li>
            </ul>
        </div>

        <div>
            <h2>Social</h2>
            <ul>
                <li><a href="#">X</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">YouTube</a></li>
                <li><a href="#">TikTok</a></li>
            </ul>
        </div>

        <div>
            <h2>Sobre nosotros</h2>
            <ul>
                <li><a href="#">Donaciones</a></li>
                <li><a href="#">Instalaciones</a></li>
                <li><a href="#">Equipo</a></li>
                <li><a href="#">Pups & Cups</a></li>
                <li><a href="#">Valores</a></li>
            </ul>
        </div>
    </article>
</section>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mascotas JS -->
<script src="../public/js/mascotas.js"></script>

</body>
</html>
