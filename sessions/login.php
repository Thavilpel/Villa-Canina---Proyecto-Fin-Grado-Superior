<?php
session_start();
require_once '../connection/db_pdo.inc'; 
$error = "";

// Definir roles claros
define('ROL_ADMIN', 1);
define('ROL_USUARIO', 2);

// Configuración de límite de intentos
$max_intentos = 5;
$lockout_time = 300; // en segundos (5 min)

// Inicializar contador de intentos
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
    $_SESSION['last_attempt'] = time();
}

// Bloqueo temporal si excede intentos
if ($_SESSION['intentos_login'] >= $max_intentos && (time() - $_SESSION['last_attempt'] < $lockout_time)) {
    $error = "⚠️ Has excedido los intentos de login. Intenta de nuevo más tarde.";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar email
    if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        !empty($_POST['password'])) {

        $email = htmlspecialchars($_POST['email']);
        $password_input = $_POST['password'];

        // Obtener usuario por email
        $sql = "SELECT id, nombre, email, password, rol_id, telefono, avatar FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $password_bd = $usuario['password'];

            $login_valido = false;

            // Verificar SHA1 antiguo y migrar
            if (strlen($password_bd) === 40 && sha1($password_input) === $password_bd) {
                $login_valido = true;
                // Migrar al hash moderno
                $nuevo_hash = password_hash($password_input, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $update->execute([$nuevo_hash, $usuario['id']]);
            } elseif (password_verify($password_input, $password_bd)) {
                $login_valido = true;
            }

            if ($login_valido) {
                // Login correcto
                session_regenerate_id(true); // Previene session fixation
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol_id'];
                $_SESSION['telefono'] = $usuario['telefono'] ?? '';
                $_SESSION['avatar'] = $usuario['avatar'] ?? 'default.png';

                // Resetear intentos
                $_SESSION['intentos_login'] = 0;

                // Redirigir según rol
                if ($usuario['rol_id'] == ROL_ADMIN) {
                    header('Location: ../pages/page_admin.php');
                    exit();
                } elseif ($usuario['rol_id'] == ROL_USUARIO) {
                    header('Location: ../index.php');
                    exit();
                } else {
                    $error = "⚠️ Rol no definido.";
                }

            } else {
                $_SESSION['intentos_login']++;
                $_SESSION['last_attempt'] = time();
                $error = "⚠️ El email o la contraseña no son correctos.";
            }

        } else {
            $_SESSION['intentos_login']++;
            $_SESSION['last_attempt'] = time();
            $error = "⚠️ El email o la contraseña no son correctos.";
        }

    } else {
        $error = "⚠️ Debes ingresar un email y contraseña válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar sesión | Villa Canina</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS propio -->
        <link rel="stylesheet" href="../public/css/style-registro.css">
    </head>

    <body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">

            <h1 class="text-center mb-4">Iniciar sesión</h1>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>

            </form>

            <div class="volver text-center mt-3">
                <a href="../index.php">Volver al inicio</a>
            </div>

        </div>
    </div>

    </body>
</html>
