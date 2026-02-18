<?php
session_start();
require_once '../connection/db_pdo.inc'; 
$error = "";

// Validar email
if (isset($_POST['email']) && !empty($_POST['email']) &&
    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

    if (isset($_POST['password']) && !empty($_POST['password'])) {

        $email = htmlspecialchars(trim($_POST['email']));
        $password_input = $_POST['password'];

        // Consulta para obtener usuario por email, incluyendo teléfono
        $sql = "SELECT id, nombre, email, password, rol_id, telefono FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_bd = $usuario['password'];

            // Verificamos si es sha1 antiguo
            if (strlen($password_bd) === 40 && sha1($password_input) === $password_bd) {
                // Login correcto, migramos a password_hash
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol_id'];
                $_SESSION['telefono'] = $usuario['telefono'] ?? '';

                // Actualizamos contraseña al hash moderno
                $nuevo_hash = password_hash($password_input, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $update->execute([$nuevo_hash, $usuario['id']]);

            } elseif (password_verify($password_input, $password_bd)) {
                // Login con hash moderno
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol_id'];
                $_SESSION['telefono'] = $usuario['telefono'] ?? '';

            } else {
                $error = "⚠️ El email o la contraseña no son correctos.";
            }

            // Redirección según rol si login correcto
            if (empty($error)) {
                if ($usuario['rol_id'] == 1) {
                    header('Location: ../pages/page_admin.php');
                    exit;
                } elseif ($usuario['rol_id'] == 2) {
                    header('Location: ../index.php');
                    exit;
                } else {
                    $error = "⚠️ Rol no definido.";
                }
            }

        } else {
            $error = "⚠️ El email o la contraseña no son correctos.";
        }

    } else {
        $error = "⚠️ La contraseña es obligatoria.";
    }

} elseif (isset($_POST['email'])) {
    $error = "⚠️ El email no es válido.";
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
