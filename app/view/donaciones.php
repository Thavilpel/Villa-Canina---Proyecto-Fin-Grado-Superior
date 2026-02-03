<!-- PHP -->
<?php
$nombreAdmin = $_SESSION['nombre'] ?? '';
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Donaciones | Panel Administrador</title>
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

        <!-- CONTENIDO PRINCIPAL-->
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

            <!-- CONTENIDO  MAIN-->
            <main class="flex-grow-1 p-4">

                <!-- CABECERA -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gestión de Donaciones</h1>
                </div>

                <!-- MENSAJE PHP -->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
                <?php endif; ?>

                <!-- FILTROS -->
                <form class="row g-3 mb-4 bg-light p-3 border rounded shadow-sm" method="GET" action="control_donaciones.php">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Nombre o Apellido</label>
                        <input type="text" name="nombre_buscar" class="form-control" placeholder="Buscar donante..." value="<?= htmlspecialchars($nombre_buscar ?? '') ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Ordenar por</label>
                        <select name="orden" class="form-select">
                            <option value="">Fecha descendente</option>
                            <option value="cantidad_desc" <?= (isset($orden) && $orden=='cantidad_desc') ? 'selected' : '' ?>>Cantidad mayor a menor</option>
                        </select>
                    </div>

                    <!-- BOTONES FILTRAR Y LIMPIAR -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="control_donaciones.php" class="btn btn-secondary w-100">Limpiar</a>
                    </div>
                </form>

                <!-- TABLA DONACIONES -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="cabecera-tabla">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Cantidad (€)</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($donaciones)): ?>
                                <?php foreach ($donaciones as $donacion): ?>
                                    <tr>
                                        <td><?= $donacion['id'] ?></td>
                                        <td><?= htmlspecialchars($donacion['nombre'].' '.$donacion['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($donacion['email']) ?></td>
                                        <td><?= htmlspecialchars($donacion['telefono'] ?? '-') ?></td>
                                        <td><?= number_format($donacion['cantidad'], 2) ?></td>
                                        <td><?= $donacion['fecha'] ?></td>
                                        <td><?= htmlspecialchars($donacion['nota'] ?? '-') ?></td>
                                        <td class="d-flex gap-2">
                                            <a href="control_donaciones.php?action=eliminar&id=<?= $donacion['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta donación?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay donaciones</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
        
        <!-- MODAL DONACIONES -->
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- FUNCIONES JS PARA MODAL -->
    </body>
</html>