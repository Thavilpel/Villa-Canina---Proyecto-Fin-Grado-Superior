<?php
session_start();

// ==== SEGURIDAD: SOLO USUARIO LOGUEADO ====
if (!isset($_SESSION['id'])) {
    header('Location: ../../sessions/login.php');
    exit;
}

// ==== CONEXIÓN Y MODELOS ====
require_once __DIR__ . '/../../connection/db_pdo.inc';
require_once __DIR__ . '/../model/gestion_usuarios.php';
require_once __DIR__ . '/../model/gestion_solicitudes.php';
require_once __DIR__ . '/../model/gestion_citas.php';

// ==== OBTENER USUARIO LOGUEADO ====
$usuario = Usuario::obtenerPorId($_SESSION['id']);
if (!$usuario) {
    die("Usuario no encontrado");
}

// ==== PROCESAR EDICIÓN DEL PERFIL ====
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_perfil'])) {
    $data = [
        'nombre'    => $_POST['nombre'],
        'apellidos' => $_POST['apellidos'],
        'telefono'  => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
        'ciudad'    => $_POST['ciudad'],
        'provincia' => $_POST['provincia'],
        'email'     => $_POST['email'],
    ];

    if (!empty($_POST['password'])) {
        $data['password'] = $_POST['password'];
    }

    // Avatar
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'avatar_' . $usuario['id'] . '.' . $ext;
        $rutaDestino = __DIR__ . '/../../public/img/avatar/' . $nombreArchivo;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaDestino)) {
            $data['avatar'] = $nombreArchivo;
        }
    }

    // Actualizar perfil en la base de datos
    $ok = Usuario::editarPerfil($_SESSION['id'], $data);
    $mensaje = $ok ? "Perfil actualizado correctamente." : "Error al actualizar perfil.";

    //Recargar datos y actualizar la sesión para el avatar
    $usuario = Usuario::obtenerPorId($_SESSION['id']);
    $_SESSION['avatar'] = $usuario['avatar'] ?? 'default.png';
}

// ==== OBTENER SOLICITUDES Y CITAS SOLO DEL USUARIO ====
$solicitudes = Solicitud::obtenerTodas('', $usuario['nombre'] . ' ' . $usuario['apellidos']);
$citas       = Cita::obtenerTodas($usuario['nombre'] . ' ' . $usuario['apellidos']);

// ==== PASAR A VISTA ====
require __DIR__ . '/../view/user-profile.php';
