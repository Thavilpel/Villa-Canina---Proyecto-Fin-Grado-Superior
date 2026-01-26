<?php
$nombreAdmin = $_SESSION['nombre'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas | Panel Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style-app.css">
</head>
<body>

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
            <li class="nav-item mb-2"><a href="control_citas.php" class="boton-verde">Citas</a></li>
            <li class="nav-item mb-2"><a href="control_donaciones.php" class="boton-verde">Donaciones</a></li>
            <li class="nav-item mb-2"><a href="control_productos.php" class="boton-verde">Productos</a></li>
            <li class="nav-item mt-4"><a href="../../sessions/logout.php" class="boton-cerrar">Cerrar sesión</a></li>
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

        <h1 class="mb-4">Gestión de Citas</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- FILTROS -->
        <form class="row g-3 mb-4 bg-light p-3 border rounded shadow-sm" method="GET" action="control_citas.php">

            <div class="col-md-4">
                <label class="form-label small fw-bold">Usuario</label>
                <input
                    type="text"
                    name="usuario_buscar"
                    class="form-control"
                    placeholder="Buscar por nombre..."
                    value="<?= htmlspecialchars($usuario_buscar ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold">Servicio</label>
                <select name="servicio_id" class="form-select">
                    <option value="">Todos los servicios</option>
                    <?php foreach ($servicios as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= (isset($servicio_id) && $servicio_id == $s['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold">Orden</label>
                <select name="orden_fecha" class="form-select">
                    <option value="DESC" <?= ($orden_fecha === 'DESC') ? 'selected' : '' ?>>Más recientes</option>
                    <option value="ASC" <?= ($orden_fecha === 'ASC') ? 'selected' : '' ?>>Más antiguas</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold">Estado Cita</label>
                <select name="estado_cita" class="form-select">
                    <option value="">Todos</option>
                    <option value="Pendiente" <?= (isset($estado_cita) && $estado_cita === 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Terminado" <?= (isset($estado_cita) && $estado_cita === 'Terminado') ? 'selected' : '' ?>>Terminado</option>
                    <option value="Cancelado" <?= (isset($estado_cita) && $estado_cita === 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div class="col-12 d-flex gap-2 mt-3">
                <button class="btn btn-primary" type="submit">Filtrar</button>
                <a href="control_citas.php" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="cabecera-tabla">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Servicio</th>
                        <th>Contacto</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                        <th>Comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($citas)): ?>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?= $cita['id'] ?></td>
                                <td><?= htmlspecialchars($cita['nombre_usuario'].' '.$cita['apellidos_usuario']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($cita['servicio'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div><?= htmlspecialchars($cita['email']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($cita['telefono'] ?? '-') ?></div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($cita['fecha_hora'])) ?></td>
                                <td>
                                    <?php
                                        $color = 'secondary';
                                        if ($cita['estado'] === 'Pendiente') $color = 'warning';
                                        if ($cita['estado'] === 'Terminado') $color = 'success';
                                        if ($cita['estado'] === 'Cancelado') $color = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($cita['estado']) ?></span>
                                </td>
                                <td><?= nl2br(htmlspecialchars($cita['comentario'] ?? '-')) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary"
                                            onclick='abrirModalEditarCita(<?= json_encode($cita) ?>)'
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditarCita">
                                        ✏️
                                    </button>
                                    <a href="control_citas.php?action=eliminar&id=<?= $cita['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Seguro que deseas eliminar esta cita?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay citas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditarCita" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="control_citas.php?action=editar" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="editarCitaId">

                <div class="mb-3">
                    <label class="form-label">Fecha y Hora</label>
                    <input type="datetime-local" name="fecha_hora" id="editarCitaFechaHora" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentario</label>
                    <textarea name="comentario" id="editarCitaComentario" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" id="editarCitaEstado" class="form-select" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Terminado">Terminado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function abrirModalEditarCita(cita) {
    document.getElementById('editarCitaId').value = cita.id;
    document.getElementById('editarCitaFechaHora').value = cita.fecha_hora;
    document.getElementById('editarCitaComentario').value = cita.comentario ?? '';
    document.getElementById('editarCitaEstado').value = cita.estado;
}
</script>

</body>
</html>
