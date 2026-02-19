<?php
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {
    header("Location: page_admin.php");
    exit();
}

$nombre = $_SESSION['nombre'] ?? null;
$avatar = $_SESSION['avatar'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Servicios | Villa Canina</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Tu CSS -->
        <link rel="stylesheet" href="../public/css/estilo_servicios.css">

        <link href="https://fonts.googleapis.com/css2?family=Yrsa&display=swap" rel="stylesheet">
    </head>

    <body>

    <!-- ================= HERO ================= -->
    <section class="hero-servicios text-center py-5">
        <h1 class="display-4 fw-bold">Nuestros Servicios</h1>
        <p class="lead">Cuidado integral, bienestar y amor para tu mejor amigo 🐶</p>
    </section>


    <!-- ================= BLOQUE PRINCIPAL ================= -->
    <section class="container py-5">

        <!-- ===== BLOQUE 1 ===== -->
        <div class="mb-5">
            <h2 class="text-center mb-4">Servicios Profesionales</h2>

            <div class="row g-4">

                <!-- Veterinario -->
                <div class="col-md-6 col-lg-3">
                    <div class="card servicio-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4>🏥 Veterinario</h4>
                            <p>Consultas, vacunas y atención médica profesional.</p>
                            <a href="page_formulario.php" class="btn btn-outline-dark btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>

                <!-- Peluquería -->
                <div class="col-md-6 col-lg-3">
                    <div class="card servicio-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4>🫧 Peluquería</h4>
                            <p>Baño, corte y cuidado estético completo.</p>
                            <a href="page_formulario.php" class="btn btn-outline-dark btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>

                <!-- Alojamiento -->
                <div class="col-md-6 col-lg-3">
                    <div class="card servicio-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4>🏨 Alojamiento</h4>
                            <p>Estancias seguras con supervisión 24/7.</p>
                            <a href="page_formulario.php" class="btn btn-outline-dark btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>

                <!-- Asesoramiento -->
                <div class="col-md-6 col-lg-3">
                    <div class="card servicio-card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4>🤝 Asesoramiento</h4>
                            <p>Orientación personalizada para el cuidado de tu mascota.</p>
                            <a href="page_formulario.php" class="btn btn-outline-dark btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- ===== BLOQUE 2 ===== -->
        <div>
            <h2 class="text-center mb-4">Compromiso y Comunidad</h2>

            <div class="row g-4 justify-content-center">

                <!-- Adopciones -->
                <div class="col-md-6 col-lg-4">
                    <div class="card servicio-destacado h-100 shadow">
                        <div class="card-body text-center">
                            <h3>🐕 Adopciones</h3>
                            <p>Dale un hogar a quien más lo necesita. Conecta y transforma vidas.</p>
                            <a href="page_formulario.php" class="btn btn-dark">Adoptar</a>
                        </div>
                    </div>
                </div>

                <!-- Donaciones -->
                <div class="col-md-6 col-lg-4">
                    <div class="card servicio-destacado h-100 shadow">
                        <div class="card-body text-center">
                            <h3>🪙 Donaciones</h3>
                            <p>Tu ayuda permite seguir cuidando y protegiendo animales.</p>
                            <a href="page_donaciones.php" class="btn btn-dark">Apoyar ahora</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>


    <!-- ================= SECCIONES DETALLE ================= -->

    <!-- ================= VETERINARIO ================= -->
    <section id="veterinario" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">🏥 Servicio Veterinario</h2>
            <p class="text-center mb-5">
                Atención médica profesional para garantizar la salud y bienestar de tu mascota.
            </p>

            <div class="row text-center g-4">

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>Vacunas</h5>
                            <p>Vacunas obligatorias y opcionales.</p>
                            <strong>Desde 25€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>Revisión General</h5>
                            <p>Chequeo completo y diagnóstico preventivo.</p>
                            <strong>35€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>Urgencias</h5>
                            <p>Atención prioritaria en situaciones críticas.</p>
                            <strong>Desde 60€</strong>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-4">
                <a href="page_veterinario.php" class="btn btn-dark">Solicitar</a>
            </div>
        </div>
    </section>


    <!-- ================= PELUQUERÍA ================= -->
    <section id="peluqueria" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">🫧 Peluquería Canina</h2>
            <p class="text-center mb-5">
                Cuidado estético profesional adaptado a cada raza y tamaño.
            </p>

            <div class="row text-center g-4">

                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6>Pequeño</h6>
                            <p>Lavado + corte</p>
                            <strong>20€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6>Mediano</h6>
                            <p>Lavado + corte</p>
                            <strong>25€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6>Grande</h6>
                            <p>Lavado + corte</p>
                            <strong>30€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h6>Desparasitación</h6>
                            <p>Tratamiento antipulgas</p>
                            <strong>Desde 15€</strong>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-4">
                <a href="page_peluqueria.php" class="btn btn-dark">Solicitar</a>
            </div>
        </div>
    </section>


    <!-- ================= ALOJAMIENTO ================= -->
    <section id="alojamiento" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">🏨 Alojamiento Canino</h2>
            <p class="text-center mb-5">
                Estancias seguras con supervisión 24/7. Descuentos por larga duración.
            </p>

            <div class="row text-center g-4">

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>1 Día</h5>
                            <p>Sin comida incluida</p>
                            <strong>18€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>3 Días</h5>
                            <p>Incluye alimentación básica</p>
                            <strong>50€</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5>5 Días</h5>
                            <p>Incluye alimentación + descuento</p>
                            <strong>75€</strong>
                        </div>
                    </div>
                </div>

            </div>

            <p class="text-center mt-4">
                Más de 7 días → 10% de descuento automático.
            </p>

            <div class="text-center">
                <a href="page_alojamiento.php" class="btn btn-dark">Reservar</a>
            </div>
        </div>
    </section>


    <!-- ================= ASESORAMIENTO ================= -->
    <section id="asesoramiento" class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">🤝 Asesoramiento y Educación</h2>

            <p>
                Cursos básicos y avanzados para mejorar la convivencia y el comportamiento de tu perro.
            </p>

            <ul class="list-unstyled mt-4">
                <li>✔ Curso básico de obediencia – 80€</li>
                <li>✔ Curso avanzado de comportamiento – 120€</li>
                <li>✔ Sesión individual personalizada – 30€</li>
            </ul>

            <a href="page_asesoramiento.php" class="btn btn-dark mt-4">Solicitar</a>
        </div>
    </section>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
