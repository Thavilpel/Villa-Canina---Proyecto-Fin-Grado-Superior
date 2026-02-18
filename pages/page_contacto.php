<?php
    session_start();

    // Verificar si hay sesión iniciada
    if (isset($_SESSION['id'])) {
        $nombre = $_SESSION['nombre'];
        $avatar = $_SESSION['avatar'] ?? 'default.png';
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Villa Canina</title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Link CSS -->
        <link rel="stylesheet" href="../public/css/estilo.css">

        <!-- Link fuente -->
        <link href="https://fonts.googleapis.com/css2?family=Yrsa&display=swap" rel="stylesheet">

        <!-- Logo en Pestaña -->
        <link rel="icon" type="image/png" href="public/img/web/logo.png">
    </head>

    <body>
        <!-- ==== CABECERA ==== -->
        <header>
            <!-- Logotipo -->
            <section class="logotipo">
                <img src="../public/img/web/logo.png" alt="Logo">
                <h1>Villa Canina</h1>
            </section>

            <!-- Navegación -->
            <nav>
                <ul class="menu">
                    <li><a href="../index.php">🏠 Inicio</a></li>
                    <li><a href="page_animales.php">🐶 Animales</a></li>
                    
                    <li><a href="page_servicios.php">✨ Servicios <span class="girar">▼</span></a>
                        <ul class="submenu">
                            <li><a href="page_servicios.php#adopciones"><span class="seleccionar">▸</span>🐕 Adopciones</a></li>
                            <li><a href="page_servicios.php#adopciones"><span class="seleccionar">▸</span>🫧 Peluquería</a></li>
                            <li><a href="page_servicios.php#adopciones"><span class="seleccionar">▸</span>🏨 Alojamiento</a></li>
                            <li><a href="page_servicios.php#adopciones">▸</span>🤝 Asesorar</a></li>
                            <li><a href="page_donaciones.php"><span class="seleccionar">▸</span>🪙 Donaciones</a></li>
                        </ul>
                    </li>

                    <li><a href="page_donaciones.php"> 🛒 Tienda</a></li>
                    <li><a href="page_contacto.php"> 📱 Contacto</a></li>
                </ul>
            </nav>

            <!-- Bloque usuario o registro -->
            <?php if (isset($_SESSION['nombre'])): ?>
            
                <!-- Usuario logueado -->
                <section class="usuario d-flex align-items-center gap-2">
                    <div>
                        <a href="page_userProfile.php">
                            <img src="../public/img/avatar/<?= htmlspecialchars($avatar) ?>" 
                                alt="Avatar" 
                                class="rounded-circle" 
                                width="70" 
                                height="70">
                        </a>
                        <span><?= htmlspecialchars($nombre) ?></span>
                    </div>
                    
                    <a href="../sessions/logout.php" class="btn btn-outline-danger btn-sm boton-cerrar">Cerrar sesión</a>
                </section>

            <?php else: ?>

                <!-- Registro / login -->
                <section class="registro">
                    <a href="sessions/login.php">Inicia Sesión</a>
                    <a href="sessions/register.php">Regístrate</a>
                </section>
                
            <?php endif; ?>
        </header>
        <!-- ======== -->
        
<!-- ================= MAIN ================= -->
<main style="padding: 2rem; max-width: 800px; margin: auto;">
    <h2>Contacto</h2>

    <p><strong>Email:</strong> contacto@villacanina.com</p>
    <p><strong>Teléfono:</strong> +34 123 456 789</p>
    <p><strong>Dirección:</strong> Calle Ficticia 123, Ciudad Ejemplo, España</p>

    <h3>Ubicación en el mapa</h3>
    <div style="width: 100%; height: 400px; margin-top: 1rem;">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.123456789!2d-0.123456!3d40.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x123456789abcdef!2sVilla%20Canina!5e0!3m2!1ses!2ses!4v1697051234567!5m2!1ses!2ses"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</main>

        <!-- ==== PIE DE PÁGINA ==== -->
        <footer>
            <section class="piePagina">
                <article>
                    <div>
                        <h1>VILLA CANINA</h1>
                        <p>
                            Villa Canina es un espacio dedicado al cuidado integral y bienestar de los perros. Aquí tu mascota encuentra atención veterinaria, alojamiento seguro, peluquería, tienda de productos y mucho cariño.
                        </p>
                    </div>

                    <div>
                        <h2>Servicios</h2>
                        <ul>
                            <li><a href="page_servicios.php#adopciones">Adopción</a></li>
                            <li><a href="page_servicios.php#alojamiento">Alojamiento</a></li>
                            <li><a href="page_servicios.php#peluqueria">Peluquería</a></li>
                            <li><a href="page_servicios.php#veterinario">Veterinario</a></li>
                            <li><a href="page_servicios.php#asesorar">Asesoramiento</a></li>
                            <li><a href="page_tienda.php">Tienda</a></li>
                        </ul>
                    </div>

                    <div>
                        <h2>Social</h2>
                        <ul>
                            <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                            <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
                            <li><a href="https://www.youtube.com" target="_blank">YouTube</a></li>
                            <li><a href="https://www.tiktok.com" target="_blank">TikTok</a></li>
                            <li><a href="https://www.x.com" target="_blank">X</a></li>
                        </ul>
                    </div>

                    <div>
                        <h2>Sobre nosotros</h2>
                        <ul>
                            <li><a href="page_animales.php">Animales</a></li>
                            <li><a href="page_contacto.php">Contacto</a></li>
                            <li><a href="page_donaciones.php">Donaciones</a></li>
                        </ul>
                    </div>
                </article>
                
            </section>
            <p id="copy">
                &copy; 2026 Villa Canina. Todos los derechos reservados.
            </p>
        </footer>
        <!-- ======== -->
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>