<?php
session_start();

// Incluir conexión PDO
require_once "../connection/db_pdo.inc"; // Ajusta la ruta según tu estructura

// Variables para mensajes de error o éxito
$errores = [];
$exito = "";

// Procesar formulario al enviar
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recoger y sanitizar datos
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $ciudad = trim($_POST['ciudad']);
    $provincia = trim($_POST['provincia']);

    // Validaciones
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($apellidos)) $errores[] = "Los apellidos son obligatorios.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email no válido.";
    if (empty($password)) $errores[] = "La contraseña es obligatoria.";
    if ($password !== $confirm_password) $errores[] = "Las contraseñas no coinciden.";

    // Si no hay errores, insertar en la BD
    if (empty($errores)) {
        // Comprobar si el email ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errores[] = "El email ya está registrado.";
        } else {
            // Hashear la contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar usuario
            $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, telefono, direccion, ciudad, provincia)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $apellidos, $email, $password_hash, $telefono, $direccion, $ciudad, $provincia]);

            $exito = "Se ha registrado correctamente. ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Villa Canina</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="../public/css/style-registro.css">
    
</head>
    <body class="registro bg-light">
        <div class=" card container mt-5" style="max-width: 600px;">
            <h2 class="text-center mb-4">Registro de Usuario</h2>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errores as $error) echo "<li>$error</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($exito): ?>
                <div class="alert alert-success">
                    <?= $exito ?> <a href="login.php">Iniciar sesión</a>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="<?= isset($nombre) ? htmlspecialchars($nombre) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" required value="<?= isset($apellidos) ? htmlspecialchars($apellidos) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="<?= isset($telefono) ? htmlspecialchars($telefono) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="<?= isset($direccion) ? htmlspecialchars($direccion) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control" value="<?= isset($ciudad) ? htmlspecialchars($ciudad) : '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" name="provincia" class="form-control" value="<?= isset($provincia) ? htmlspecialchars($provincia) : '' ?>">
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>

            <p class="volver mt-3 text-center">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a> o <a href="../index.php">vuelve al inicio</a>
            </p>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
