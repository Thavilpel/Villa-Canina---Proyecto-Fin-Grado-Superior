<!-- PHP -->
<?php
$nombreAdmin = $_SESSION['nombre'] ?? '';
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Solicitudes | Panel Administrador</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS -->
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

        <!-- CONTENIDO PRINCIPAL -->
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

            <!-- CONTENIDO MAIN -->
            <main class="flex-grow-1 p-4">

                <!-- CABECERA -->
                <h1 class="mb-4">Gestión de Solicitudes</h1>
                
                <!-- MENSAJE PHP -->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
                <?php endif; ?>

                <!-- FILTROS -->
                <form class="row g-3 mb-4 bg-light p-3 border rounded shadow-sm" method="GET" action="control_solicitudes.php">

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
                                <option value="<?= $s['id'] ?>" <?= ($servicio_id == $s['id']) ? 'selected' : '' ?>>
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
                        <select name="tiene_cita" class="form-select">
                            <option value="">Todas</option>
                            <option value="1" <?= (isset($tiene_cita) && $tiene_cita === '1') ? 'selected' : '' ?>>Con cita</option>
                            <option value="0" <?= (isset($tiene_cita) && $tiene_cita === '0') ? 'selected' : '' ?>>Sin cita</option>
                        </select>
                    </div>


                    <!-- BOTONES FILTRAR Y LIMPIAR -->
                    <div class="col-12 d-flex gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                        <a href="control_solicitudes.php" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>

                <!-- TABLA SOLICITUDES -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="cabecera-tabla">
                            <tr>
                                <th style="min-width: 150px;">Usuario</th>
                                <th style="min-width: 120px;">Servicio</th>
                                <th style="min-width: 180px;">Contacto</th>
                                <th style="min-width: 250px;">Descripción</th>
                                <th style="min-width: 140px;">Fecha</th>
                                <th style="min-width: 130px;">Estado Cita</th>
                                <th style="min-width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($solicitudes)): ?>
                            <?php foreach ($solicitudes as $sol): ?>
                                <tr>
                                    <td class="text-truncate" style="max-width:150px;" title="<?= htmlspecialchars($sol['nombre_usuario'] . ' ' . $sol['apellidos_usuario']) ?>">
                                        <?= htmlspecialchars($sol['nombre_usuario'] . ' ' . $sol['apellidos_usuario']) ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark"><?= htmlspecialchars($sol['servicio']) ?></span>
                                    </td>
                                    <td style="max-width:180px;">
                                        <div class="text-truncate" title="<?= htmlspecialchars($sol['email']) ?>"><?= htmlspecialchars($sol['email']) ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($sol['telefono'] ?? '-') ?></div>
                                    </td>
                                    <td class="small" style="max-width:250px; word-wrap: break-word;">
                                        <?= nl2br(htmlspecialchars($sol['descripcion'])) ?>
                                    </td>
                                    <td class="text-center"><?= date('d/m/Y H:i', strtotime($sol['fecha_solicitud'])) ?></td>

                                    <!-- Estado Cita -->
                                    <td class="text-center">
                                        <?php if ($sol['tiene_cita']): ?>
                                            <span class="badge bg-success">Cita programada</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Sin cita</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <!-- Botón de crear cita solo si no tiene cita -->
                                        <button class="btn btn-sm btn-primary mb-1"
                                                onclick="abrirModalCita(<?= $sol['id'] ?>)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalCita"
                                                <?= $sol['tiene_cita'] ? 'disabled' : '' ?>>
                                            📅
                                        </button>
                                        <a href="control_solicitudes.php?action=eliminar&id=<?= $sol['id'] ?>"
                                        class="btn btn-sm btn-danger mb-1"
                                        onclick="return confirm('¿Seguro que deseas eliminar esta solicitud?')">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay solicitudes</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>


            </main>
        </div>

        <!-- MODAL SOLICITUDES -->
        <div class="modal fade" id="modalCita" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="control_solicitudes.php?action=crear_cita" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Programar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="solicitud_id" id="solicitud_id_input">
                        <div class="mb-3">
                            <label class="form-label">Fecha y Hora</label>
                            <input type="datetime-local" name="fecha_hora" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nota</label>
                            <textarea name="comentario" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- FUNCIONES JS PARA MODAL -->
        <script>
            function abrirModalCita(id) {
                document.getElementById('solicitud_id_input').value = id;
            }
        </script>

    </body>
</html>