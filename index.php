<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Canina</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link css -->
    <link rel="stylesheet" href="public/css/style-index.css">


    <!-- Link fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Yrsa&display=swap" rel="stylesheet">

    <!-- Logo en Pestaña -->
    <link rel="icon" type="image/png" href="public/img/web/logo.png">

</head>
<body>
    <header class="d-flex justify-content-between align-items-center flex-wrap">
        <!-- Logotipo -->
        <section class="logotipo">
            <img src="public/img/web/logo.png" alt="Logo">
            <h1>Villa Canina</h1>
        </section>

        <!-- Navegación -->
        <nav>
            <ul>
                <li><a href="pages/page_animales.php">Animales</a></li>
                <li><a href="#">Adopciones</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Donaciones</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Sobre nosotros</a></li>
            </ul>
        </nav>

        <!-- Registro -->
        <section class="registro">
            <a href="sessions/login.php">Inicia Sesión</a>
            <a href="sessions/register.php">Regístrate</a>
        </section>
    </header>

    <main>
        <!-- SECCIÓN ADOPCIÓN -->
        <section class="caja_adopcion text-center py-5 px-3 mx-auto">
            <p class="eslogan fw-bold display-6 mb-4">
                UN LUGAR PARA DEJAR HUELLA
            </p>

            <div class="elementos-linea d-flex justify-content-center align-items-center flex-wrap mb-4 gap-3">
                <h2 class="m-0">ADOPCIÓN</h2>
                <img src="public/img/web/icono-corazon.png" alt="corazón" class="separador" width="30">
                <h2 class="m-0">CONEXIÓN</h2>
                <img src="public/img/web/icono-corazon.png" alt="corazón" class="separador" width="30">
                <h2 class="m-0">BIENESTAR</h2>
            </div>

            <p class="subtexto mb-4 fs-5">
                Conoce a los miembros de nuestra familia
            </p>

            <a href="#" class="boton-ver-animal btn btn-lg">
                VER ANIMAL
            </a>
        </section>
        
        <!-- SECCIÓN SERVICIOS -->
        <section class="servicios">
            <div class="container">
                <div class="row g-4">

                    <!-- Tarjeta Veterinario -->
                    <div class="col-12 col-lg-6">
                        <article class="tarjeta">
                            <a href="#">
                                <img src="public/img/web/veterinario.png" alt="Veterinario" class="tarjeta-img">
                                <div class="tarjeta-body">
                                    <h3>Veterinario</h3>
                                    <p>Atención profesional para la salud de tu mascota. Consultas, vacunas y cuidado integral.</p>
                                </div>
                            </a>
                        </article>
                    </div>

                    <!-- Tarjeta Alojamiento -->
                    <div class="col-12 col-lg-6">
                        <article class="tarjeta">
                            <a href="#">
                                <img src="public/img/web/alojamiento.png" alt="Alojamiento" class="tarjeta-img">
                                <div class="tarjeta-body">
                                    <h3>Alojamiento</h3>
                                    <p>Hospedaje cómodo y seguro para tu mascota, con supervisión 24/7 y áreas de juego.</p>
                                </div>
                            </a>
                        </article>
                    </div>

                    <!-- Tarjeta Tienda -->
                    <div class="col-12 col-lg-6">
                        <article class="tarjeta">
                            <a href="#">
                                <img src="public/img/web/tienda.png" alt="Tienda" class="tarjeta-img">
                                <div class="tarjeta-body">
                                    <h3>Tienda</h3>
                                    <p>Todo lo que tu mascota necesita: alimentos, juguetes, accesorios y más.</p>
                                </div>
                            </a>
                        </article>
                    </div>

                    <!-- Tarjeta Peluquería -->
                    <div class="col-12 col-lg-6">
                        <article class="tarjeta">
                            <a href="#">
                                <img src="public/img/web/peluqueria.png" class="tarjeta-img">
                                <div class="tarjeta-body">
                                    <h3>Peluquería</h3>
                                    <p>Estilismo y cuidado estético para tu mascota. Cortes, baños y spa completo.</p>
                                </div>
                            </a>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECCIÓN PUBLICIDAD -->
        <section class="publi">
            <article class="donar">
                <h3>DEJA TU HUELLA</h3>
                <p>GRACIAS A TU APOYO, NUESTROS AMIGOS RECIBEN CARIÑO Y CUIDADO</p>
                <a href="#" class="btn-donar">
                    <img src="public/img/web/icono-corazon.png" alt="corazón">
                    DONAR
                    <img src="public/img/web/icono-corazon.png" alt="corazón">
                </a>
            </article>

            <article class="info-publi">
                <div class="redes">
                    <h3>¿QUIERES APOYAR?</h3>
                    <p>LO BUENO SIEMPRE SE COMPARTE</p>
                    <div class="iconosRedes">
                        <img src="public/img/web/facebook.png" alt="">
                        <img src="public/img/web/instagram.png" alt="">
                        <img src="public/img/web/x.png" alt="">
                        <img src="public/img/web/tiktok.png" alt="">
                    </div>
                </div>

                <div class="adoptar">
                    <h3>¿QUIERES ADOPTAR?</h3>
                    <p>CREA CONEXIONES ÚNICAS</p>
                    <a href="#" class="btn-adoptar">TU AMIGO TE ESPERA</a>
                </div>
            </article>
        </section>

        <!-- CARRUSEL -->
        <div id="carruselVillaCanina" class="carousel slide mx-auto" data-bs-ride="carousel" style="max-width: 100%;">
            <!-- Indicadores -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carruselVillaCanina" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carruselVillaCanina" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carruselVillaCanina" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carruselVillaCanina" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carruselVillaCanina" data-bs-slide-to="4"></button>
            </div>

            <!-- Imágenes -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="public/img/web/imagen1.jpg" class="d-block w-100" alt="Imagen 1">
                </div>
                <div class="carousel-item">
                    <img src="public/img/web/imagen2.jpg" class="d-block w-100" alt="Imagen 2">
                </div>
                <div class="carousel-item">
                    <img src="public/img/web/imagen3.jpg" class="d-block w-100" alt="Imagen 3">
                </div>
                <div class="carousel-item">
                    <img src="public/img/web/imagen4.jpg" class="d-block w-100" alt="Imagen 4">
                </div>
                <div class="carousel-item">
                    <img src="public/img/web/imagen5.jpg" class="d-block w-100" alt="Imagen 5">
                </div>
            </div>

            <!-- Flecha izquierda personalizada -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carruselVillaCanina" data-bs-slide="prev">
                <span class="custom-arrow">
                    <img src="public/img/web/huellaiz.png" alt="Anterior">
                </span>
                <span class="visually-hidden">Anterior</span>
            </button>

            <!-- Flecha derecha personalizada -->
            <button class="carousel-control-next" type="button" data-bs-target="#carruselVillaCanina" data-bs-slide="next">
                <span class="custom-arrow">
                    <img src="public/img/web/huellader.png" alt="Siguiente">
                </span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <!-- SECCIÓN INFORMACIÓN -->
        <section class="informacion_final d-flex justify-content-between flex-wrap">
            <!-- Contacto -->
            <article class="contacto">
                <div class="contacto-item">
                    <img src="public/img/web/telefono.png" alt="Teléfono">
                    <p>900 123 456</p>
                </div>
                <div class="contacto-item">
                    <img src="public/img/web/email.png" alt="Correo">
                    <p>contacto@villacanina.com</p>
                </div>
                <div class="contacto-item">
                    <img src="public/img/web/ubicacion.png" alt="Dirección">
                    <p>Calle Ficticia 123, Ciudad Torrevieja, Alicante, España</p>
                </div>
                <div class="contacto-item">
                    <img src="public/img/web/reloj.png" alt="Horario">
                    <p>LUNES A VIERNES 09:00 - 18:00. SÁBADOS Y DOMINGOS: 10:00 - 14:00</p>
                </div>
            </article>

            <!-- Email / suscripción -->
            <article class="email">
                <h3>RECIBE LAS NOVEDADES DE VILLA CANINA</h3>
                <div class="form-suscripcion">
                    <input type="text" placeholder="tu email">
                    <a href="#" class="btn-suscribirse">SUSCRÍBETE</a>
                </div>
            </article>
        </section>

    </main>

    <!-- PIE DE PÁGINA -->
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
</body>
</html>