<?php
session_start();

// ==== Seguridad: solo usuarios normales ====
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 2) {
    header("Location: ../sessions/login.php");
    exit;
}

require_once __DIR__ . '/../connection/db_pdo.inc';

// ==== Datos del usuario ====
$nombre = $_SESSION['nombre'];
$avatar = $_SESSION['avatar'] ?? 'default.png';
$usuario_id = $_SESSION['id'];
$telefono = $_SESSION['telefono'] ?? '';
$email = $_SESSION['email'] ?? '';

// ==== Mensaje ====
$mensaje = "";

// ==== Procesar envío de formulario ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = floatval($_POST['cantidad'] ?? 0);
    $nota = trim($_POST['nota'] ?? '');

    if ($cantidad <= 0) {
        $mensaje = "⚠️ Debes ingresar una cantidad válida.";
    } else {
        // Guardar donación en base de datos
        $stmt = $pdo->prepare("INSERT INTO donaciones (usuario_id, cantidad, nota, fecha) VALUES (:usuario_id, :cantidad, :nota, NOW())");
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':cantidad' => $cantidad,
            ':nota' => $nota
        ]);
        $mensaje = "✅ ¡Gracias por tu donación de " . number_format($cantidad, 2) . " €!";
    }
}

// ==== Obtener historial de donaciones del usuario ====
$stmt = $pdo->prepare("SELECT * FROM donaciones WHERE usuario_id = :usuario_id ORDER BY fecha DESC");
$stmt->execute([':usuario_id' => $usuario_id]);
$donaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Donaciones - Villa Canina</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Link CSS -->
        <link rel="stylesheet" href="../public/css/estilo_formulario.css">

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
                    <li><a href="page_contacto.php"> 📱Contacto</a></li>
                </ul>
            </nav>

            <!-- Usuario logueado -->
            <section class="usuario d-flex align-items-center gap-2">
                <div>
                    <a href="page_userProfile.php">
                        <img src="../public/img/avatar/<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="rounded-circle" width="70" height="70">
                    </a>
                        <span><?= htmlspecialchars($nombre) ?></span>
                </div>
                <a href="../sessions/logout.php" class="btn btn-outline-danger btn-sm boton-cerrar">Cerrar sesión</a>
            </section>
        </header>
        <!-- ======== -->

<main class="container my-5">
    <h2 class="mb-4">Realizar Donación</h2>

    <?php if($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- Formulario de donación -->
    <form method="POST" class="needs-validation mb-5" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Tu email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Tu teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad (€)</label>
            <input type="number" step="0.01" min="1" class="form-control" id="cantidad" name="cantidad" required>
            <div class="invalid-feedback">Debes ingresar una cantidad válida.</div>
        </div>

        <div class="mb-3">
            <label for="nota" class="form-label">Nota (opcional)</label>
            <textarea class="form-control" id="nota" name="nota" rows="3" placeholder="Mensaje para la fundación..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Donar</button>
    </form>

    <!-- Historial de donaciones -->
    <h3 class="mb-3">Tu historial de donaciones</h3>
    <?php if($donaciones): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cantidad (€)</th>
                        <th>Nota</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($donaciones as $donacion): ?>
                        <tr>
                            <td><?= $donacion['id'] ?></td>
                            <td><?= number_format($donacion['cantidad'], 2) ?></td>
                            <td><?= htmlspecialchars($donacion['nota'] ?? '-') ?></td>
                            <td><?= $donacion['fecha'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No has realizado donaciones todavía.</p>
    <?php endif; ?>
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
