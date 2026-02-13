<?php
    session_start();

    // ==== SEGURIDAD: SOLO ADMIN ====
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
        header('Location: ../../sessions/login.php');
        exit;
    }

    // ==== CONEXIÓN Y MODELO ====
    require_once __DIR__ . '/../../connection/db_pdo.inc';
    require_once __DIR__ . '/../model/gestion_mascotas.php';

    $mensaje = "";
    $nombreAdmin = $_SESSION['nombre'] ?? '';

    // ==== FILTROS ====
    $id_buscar = $_GET['id_buscar'] ?? '';
    $filtro_estado = $_GET['estado'] ?? '';

    $filtros = [];
    if ($id_buscar !== '') {
        $filtros['id'] = $id_buscar;
    }
    if ($filtro_estado !== '') {
        $filtros['estado'] = $filtro_estado;
    }

    // ==== ACCIONES ====
    $action = $_GET['action'] ?? 'index';

        // ==== CREAR MASCOTA ====
        if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombreImagen = 'default.png';

            // ==== SUBIDA DE IMAGEN ====
            if (!empty($_FILES['imagen_file']['name'])) {

                $archivo = $_FILES['imagen_file'];
                $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
                $permitidos = ['jpg','jpeg','png','webp'];

                if (in_array($extension, $permitidos)) {

                    $nombreImagen = uniqid('mascota_') . '.' . $extension;
                    $rutaDestino = __DIR__ . '/../../public/img/mascotas/' . $nombreImagen;

                    move_uploaded_file($archivo['tmp_name'], $rutaDestino);
                }
            }

            $datos = [
                'nombre'      => $_POST['nombre'] ?? '',
                'raza'        => $_POST['raza'] ?? null,
                'genero'      => $_POST['genero'] ?? 'M',
                'edad'        => $_POST['edad'] ?? null,
                'descripcion' => $_POST['descripcion'] ?? null,
                'estado'      => $_POST['estado'] ?? 'disponible',
                'imagen'      => $nombreImagen,
                'usuario_id'  => $_POST['usuario_id'] ?? null,
                'fecha_adopcion' => date('Y-m-d')
            ];

            Mascota::crear($datos);

            header("Location: control_mascotas.php");
            exit;
        }


        // ==== EDITAR MASCOTA ====
        if ($action === 'editar' && isset($_GET['id'])) {

            $id = (int)$_GET['id'];
            $mascota = Mascota::obtenerPorId($id);

            if (!$mascota) {
                header("Location: control_mascotas.php");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $nombreImagen = $mascota['imagen'];

                // ==== SI SE SUBE NUEVA IMAGEN ====
                if (!empty($_FILES['imagen_file']['name'])) {

                    $archivo = $_FILES['imagen_file'];
                    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
                    $permitidos = ['jpg','jpeg','png','webp'];

                    if (in_array($extension, $permitidos)) {

                        // borrar imagen anterior si no es default
                        if ($mascota['imagen'] !== 'default.jpg') {
                            $rutaAnterior = __DIR__ . '/../../public/img/mascotas/' . $mascota['imagen'];
                            if (file_exists($rutaAnterior)) {
                                unlink($rutaAnterior);
                            }
                        }

                        $nombreImagen = uniqid('mascota_') . '.' . $extension;
                        $rutaDestino = __DIR__ . '/../../public/img/mascotas/' . $nombreImagen;

                        move_uploaded_file($archivo['tmp_name'], $rutaDestino);
                    }
                }

                $datos = [
                    'nombre'      => $_POST['nombre'] ?? $mascota['nombre'],
                    'raza'        => $_POST['raza'] ?? $mascota['raza'],
                    'genero'      => $_POST['genero'] ?? $mascota['genero'],
                    'edad'        => $_POST['edad'] ?? $mascota['edad'],
                    'descripcion' => $_POST['descripcion'] ?? $mascota['descripcion'],
                    'estado'      => $_POST['estado'] ?? $mascota['estado'],
                    'imagen'      => $nombreImagen,
                    'usuario_id'  => $_POST['usuario_id'] ?? null,
                    'fecha_adopcion' => date('Y-m-d')
                ];

                Mascota::actualizar($id, $datos);

                header("Location: control_mascotas.php");
                exit;
            }
        }


        // ==== ELIMINAR MASCOTA ====
        if ($action === 'eliminar' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            try {
                Mascota::eliminar($id);
                $mensaje = "✅ Mascota eliminada correctamente";
            } catch (PDOException $e) {
                $mensaje = "⚠️ No se puede eliminar la mascota, tiene adopciones registradas.";
            }
            header("Location: control_mascotas.php");
            exit;
        }

    // ==== OBTENER MASCOTAS FILTRADAS ====
    $mascotas = Mascota::obtenerTodas($filtros);
    $usuarios = Mascota::obtenerUsuarios();

    // ==== CARGAR VISTA ====
    require __DIR__ . '/../view/mascotas.php';
?>
