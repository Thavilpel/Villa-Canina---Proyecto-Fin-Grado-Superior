<?php
session_start();

// ==== Seguridad: solo usuarios normales ====
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 2) {
    header("Location: ../sessions/login.php");
    exit;
}

require_once __DIR__ . '/../app/model/gestion_solicitudes.php';

// ==== Datos del usuario ====
$nombre = $_SESSION['nombre'];
$avatar = $_SESSION['avatar'] ?? 'default.png';
$usuario_id = $_SESSION['id'];
$telefono = $_SESSION['telefono'] ?? '';
$email = $_SESSION['email'] ?? '';

// ==== Mensaje ====
$mensaje = "";

// ==== Lista de servicios desde BD ====
require_once __DIR__ . '/../connection/db_pdo.inc';
$servicios = $pdo->query("SELECT * FROM servicios ORDER BY nombre ASC")->fetchAll();

// ==== Procesar envío de formulario ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicio_id = $_POST['servicio_id'] ?? '';
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($servicio_id === '') {
        $mensaje = "⚠️ Debes seleccionar un servicio.";
    } else {
        // Guardar solicitud en la base de datos
        $creada = Solicitud::crear([
            'usuario_id' => $usuario_id,
            'servicio_id' => $servicio_id,
            'telefono' => $telefono,
            'email' => $email,
            'descripcion' => $descripcion
        ]);

        if ($creada) {
            $mensaje = "✅ Tu solicitud ha sido enviada correctamente.";
        } else {
            $mensaje = "⚠️ Hubo un error al enviar la solicitud.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Solicitar Servicio - Villa Canina</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../public/css/style-index.css">
<link href="https://fonts.googleapis.com/css2?family=Yrsa&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="../public/img/web/logo.png">
</head>
<body>

<header class="d-flex justify-content-between align-items-center flex-wrap p-3 border-bottom">
    <section class="logotipo d-flex align-items-center gap-2">
        <img src="../public/img/web/logo.png" alt="Logo" width="50">
        <h1 class="h4 m-0">Villa Canina</h1>
    </section>

    <nav>
        <ul class="nav">
            <li class="nav-item"><a href="#" class="nav-link">Animales</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Adopciones</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Servicios</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Donaciones</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Contacto</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Sobre nosotros</a></li>
        </ul>
    </nav>

    <section class="usuario d-flex align-items-center gap-2">
        <img src="../public/img/avatar/<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="rounded-circle" width="50" height="50">
        <span><?= htmlspecialchars($nombre) ?></span>
        <a href="../sessions/logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </section>
</header>

<main class="container my-5">
    <h2 class="mb-4">Solicitar Servicio</h2>

    <?php if($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Tu email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Tu teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="servicio_id" class="form-label">Tipo de servicio</label>
            <select class="form-select" id="servicio_id" name="servicio_id" required>
                <option value="" disabled selected>Selecciona un servicio</option>
                <?php foreach($servicios as $servicio): ?>
                    <option value="<?= $servicio['id'] ?>"><?= htmlspecialchars($servicio['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecciona un servicio.
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción adicional (opcional)</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Agrega detalles sobre tu solicitud"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
        <a href="page_perfil.php">Actualizar datos</a>
    </form>
</main>

<footer class="mt-5 bg-light py-3 text-center border-top">
    &copy; 2026 Villa Canina. Todos los derechos reservados.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
