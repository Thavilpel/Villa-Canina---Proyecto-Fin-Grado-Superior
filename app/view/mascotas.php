<?php
require_once __DIR__ . '/../model/gestion_mascotas.php';

$nombreAdmin = $_SESSION['nombre'] ?? '';
$usuarios = Mascota::obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mascotas | Panel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style-app.css">
</head>
<body>

<!-- BOTÓN HAMBURGUESA MÓVIL -->
<nav class="navbar bg-header d-md-none">
    <div class="container-fluid">
        <button class="btn btn-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            ☰
        </button>
    </div>
</nav>

<div class="d-flex">

    <!-- SIDEBAR -->
    <nav class="sidebar bg-header d-none d-md-block min-vh-100 p-3">
        <div class="text-center mb-4">
            <h2>Villa Canina</h2>
            <p class="fw-bold"><?= htmlspecialchars($nombreAdmin) ?></p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="../../pages/page_admin.php" class="boton-verde">Inicio</a></li>
                    <li class="nav-item mb-2"><a href="control_usuarios.php" class="boton-verde">Usuarios</a></li>
                    <li class="nav-item mb-2"><a href="control_mascotas.php" class="boton-verde">Mascotas</a></li>
                    <li class="nav-item mb-2"><a href="control_solicitudes.php" class="boton-verde">Solicitudes</a></li>
                    <li class="nav-item mb-2"><a href="#" class="boton-verde">Citas</a></li>
                    <li class="nav-item mb-2"><a href="#" class="boton-verde">Donaciones</a></li>
                    <li class="nav-item mb-2"><a href="#" class="boton-verde">Productos</a></li>
                    <li class="nav-item mt-4"><a href="../sessions/logout.php" class="boton-cerrar">Cerrar sesión</a></li>
        </ul>
    </nav>

    <!-- OFFCANVAS MÓVIL -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header">
            <div>
                <h3>Villa Canina</h3>
                <p class="fw-bold"><?= htmlspecialchars($nombreAdmin) ?></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-4">
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="../pages/page_admin.php" class="boton-verde">Inicio</a></li>
                <li class="nav-item mb-2"><a href="control_usuarios.php" class="boton-verde">Usuarios</a></li>
                <li class="nav-item mb-2"><a href="control_mascotas.php" class="boton-verde">Mascotas</a></li>
                <li class="nav-item mb-2"><a href="control_solicitudes.php" class="boton-verde">Solicitudes</a></li>
                <li class="nav-item mb-2"><a href="control_citas.php" class="boton-verde">Citas</a></li>
                <li class="nav-item mb-2"><a href="control_donaciones.php" class="boton-verde">Donaciones</a></li>
                <li class="nav-item mb-2"><a href="control_productos.php" class="boton-verde">Productos</a></li>
                <li class="nav-item mt-4"><a href="../sessions/logout.php" class="boton-cerrar">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>

    <!-- CONTENIDO -->
    <main class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Mascotas</h1>
            <button class="btn boton-crear" data-bs-toggle="modal" data-bs-target="#mascotaModal" onclick="abrirModalCrear()">
                + Nueva mascota
            </button>
        </div>

        <!-- FILTROS -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <!-- Botones de filtro -->
            <div>
                <a href="control_mascotas.php" class="btn btn-secondary">Todos</a>
                <a href="control_mascotas.php?estado=disponible" class="btn btn-success">Disponibles</a>
                <a href="control_mascotas.php?estado=adoptado" class="btn btn-danger">Adoptados</a>
            </div>

            <!-- Buscador por ID -->
            <form method="get" class="d-flex" style="gap:0.5rem;">
                <input type="hidden" name="action" value="index">
                <input type="number" name="id_buscar" class="form-control" placeholder="Buscar por ID mascota">
                <button class="btn btn-primary">🔍</button>
            </form>
        </div>

        <!-- TABLA MASCOTAS -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="cabecera-tabla">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Género</th>
                        <th>Edad</th>
                        <th>Estado</th>
                        <th>Adoptado por</th>
                        <th>Fecha adopción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mascotas)): ?>
                        <?php foreach ($mascotas as $mascota): ?>
                            <tr>
                                <td><?= $mascota['id'] ?></td>
                                <td><?= htmlspecialchars($mascota['nombre']) ?></td>
                                <td><?= htmlspecialchars($mascota['raza'] ?? '-') ?></td>
                                <td><?= $mascota['genero'] === 'M' ? 'Macho' : 'Hembra' ?></td>
                                <td><?= $mascota['edad'] ?? '-' ?></td>
                                <td>
                                    <span class="badge <?= $mascota['estado'] === 'adoptado' ? 'bg-danger' : 'bg-success' ?>">
                                        <?= ucfirst($mascota['estado']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($mascota['usuario_nombre'] ?? '-') ?></td>
                                <td><?= $mascota['fecha_adopcion'] ?? '-' ?></td>
                                <td class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-sm boton-editar"
                                        onclick='abrirModalEditar(<?= json_encode($mascota) ?>)'
                                        data-bs-toggle="modal" data-bs-target="#mascotaModal">✏️</button>
                                    <a href="control_mascotas.php?action=eliminar&id=<?= $mascota['id'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Eliminar esta mascota?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay mascotas registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- MODAL MASCOTA -->
<div class="modal fade" id="mascotaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formMascota" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="mascotaModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="mascotaId">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Raza</label>
                            <input type="text" name="raza" id="raza" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Género</label>
                            <select name="genero" id="genero" class="form-control">
                                <option value="M">Macho</option>
                                <option value="F">Hembra</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="disponible">Disponible</option>
                            <option value="adoptado">Adoptado</option>
                        </select>
                    </div>

                    <div class="mb-3" id="divUsuarioAdopcion" style="display:none;">
                        <label>Usuario adoptante</label>
                        <select name="usuario_id" id="usuario_id" class="form-control">
                            <option value="">-- Seleccionar usuario --</option>
                            <?php foreach($usuarios as $usuario): ?>
                                <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nombre'].' ('.$usuario['email'].')') ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="mt-2">Fecha de adopción</label>
                        <input type="date" name="fecha_adopcion" id="fecha_adopcion" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const estado = document.getElementById('estado');
    const divUsuarioAdopcion = document.getElementById('divUsuarioAdopcion');
    const usuario_id = document.getElementById('usuario_id');
    const fecha_adopcion = document.getElementById('fecha_adopcion');
    const mascotaModalLabel = document.getElementById('mascotaModalLabel');
    const formMascota = document.getElementById('formMascota');
    const mascotaId = document.getElementById('mascotaId');
    const nombre = document.getElementById('nombre');
    const raza = document.getElementById('raza');
    const genero = document.getElementById('genero');
    const edad = document.getElementById('edad');
    const descripcion = document.getElementById('descripcion');

    estado.addEventListener('change', function() {
        if (estado.value === 'adoptado') {
            divUsuarioAdopcion.style.display = 'block';
        } else {
            divUsuarioAdopcion.style.display = 'none';
            usuario_id.value = '';
        }
    });

    function abrirModalCrear() {
        mascotaModalLabel.innerText = "Nueva Mascota";
        formMascota.action = "control_mascotas.php?action=crear";
        formMascota.reset();
        divUsuarioAdopcion.style.display = 'none';
        fecha_adopcion.value = '<?= date('Y-m-d') ?>';
    }

    function abrirModalEditar(m) {
        mascotaModalLabel.innerText = "Editar Mascota";
        formMascota.action = "control_mascotas.php?action=editar&id=" + m.id;

        mascotaId.value = m.id;
        nombre.value = m.nombre;
        raza.value = m.raza || '';
        genero.value = m.genero;
        edad.value = m.edad || '';
        descripcion.value = m.descripcion || '';
        estado.value = m.estado;

        if (m.estado === 'adoptado') {
            divUsuarioAdopcion.style.display = 'block';
            usuario_id.value = m.usuario_id || '';
            fecha_adopcion.value = m.fecha_adopcion ? m.fecha_adopcion.split(' ')[0] : '<?= date('Y-m-d') ?>';
        } else {
            divUsuarioAdopcion.style.display = 'none';
            usuario_id.value = '';
            fecha_adopcion.value = '<?= date('Y-m-d') ?>';
        }
    }
</script>

</body>
</html>
