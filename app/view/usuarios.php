<!-- PHP -->
<?php
$nombreAdmin = $_SESSION['nombre'] ?? '';
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Usuarios | Panel Administrador</title>
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

            <!-- CONTENIDO -->
            <main class="flex-grow-1 p-4">

                <!-- CABECERA -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Gestión de Usuarios</h1>
                    <button class="btn boton-crear" data-bs-toggle="modal" data-bs-target="#usuarioModal" onclick="abrirModalCrear()">
                        + Nuevo usuario
                    </button>
                </div>

                <!-- MENSAJE php-->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
                <?php endif; ?>

                <!-- FILTROS -->
                <form class="row g-3 mb-4 bg-light p-3 border rounded shadow-sm" method="GET" action="control_usuarios.php">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Nombre o Apellido</label>
                        <input type="text" name="nombre_buscar" class="form-control" placeholder="Buscar usuario..." value="<?= htmlspecialchars($nombre_buscar ?? '') ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">ID Usuario</label>
                        <input type="number" name="id_buscar" class="form-control" placeholder="ID" value="<?= htmlspecialchars($id_buscar ?? '') ?>">
                    </div>

                    <!-- BOTONES FILTRAR Y LIMPIAR -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="control_usuarios.php" class="btn btn-secondary w-100">Limpiar</a>
                    </div>
                </form>

                <!-- TABLA USUARIOS-->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="cabecera-tabla">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Ciudad</th>
                                <th>Provincia</th>
                                <th>Rol</th>
                                <th>Donación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario['id'] ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre'].' '.$usuario['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                                        <td><?= htmlspecialchars($usuario['telefono'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($usuario['ciudad'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($usuario['provincia'] ?? '-') ?></td>
                                        <td><?= $usuario['rol_id'] == 1 ? 'Admin' : 'Usuario' ?></td>
                                        <td><?= number_format($usuario['donacion_total'] ?? 0, 2) ?> €</td>
                                        <td class="d-flex gap-2">
                                            <button class="btn btn-sm boton-editar" onclick='abrirModalEditar(<?= json_encode($usuario) ?>)' data-bs-toggle="modal" data-bs-target="#usuarioModal">✏️</button>

                                            <a href="control_usuarios.php?action=eliminar&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No hay usuarios</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>

        <!-- MODAL USUARIO -->
        <div class="modal fade" id="usuarioModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formUsuario" method="POST" action="control_usuarios.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Crear Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="usuarioId">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="usuarioNombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" id="usuarioApellidos" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="usuarioEmail" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="usuarioPassword">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" name="telefono" id="usuarioTelefono" pattern="[0-9]{9,15}" title="Solo números, mínimo 9 dígitos" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" id="usuarioDireccion">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" id="usuarioCiudad">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provincia</label>
                                    <input type="text" class="form-control" name="provincia" id="usuarioProvincia">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Rol</label>
                                    <select class="form-select" name="rol_id" id="usuarioRol" required>
                                        <option value="1">Administrador</option>
                                        <option value="2">Usuario</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- FUNCIONES JS PARA MODAL -->
        <script>
            function abrirModalCrear() {
                document.getElementById('modalTitle').textContent = 'Crear Usuario';
                document.getElementById('formUsuario').action = 'control_usuarios.php?action=crear'; 
                // Limpiar todos los campos
                ['usuarioId','usuarioNombre','usuarioApellidos','usuarioEmail','usuarioPassword',
                'usuarioTelefono','usuarioDireccion','usuarioCiudad','usuarioProvincia'].forEach(id=>{
                    document.getElementById(id).value = '';
                });
                document.getElementById('usuarioRol').value = '2';
            }

            function abrirModalEditar(usuario) {
                document.getElementById('modalTitle').textContent = 'Editar Usuario';
                document.getElementById('formUsuario').action = 'control_usuarios.php?action=editar';
                document.getElementById('usuarioId').value = usuario.id;
                document.getElementById('usuarioNombre').value = usuario.nombre;
                document.getElementById('usuarioApellidos').value = usuario.apellidos;
                document.getElementById('usuarioEmail').value = usuario.email;
                document.getElementById('usuarioTelefono').value = usuario.telefono ?? '';
                document.getElementById('usuarioDireccion').value = usuario.direccion ?? '';
                document.getElementById('usuarioCiudad').value = usuario.ciudad ?? '';
                document.getElementById('usuarioProvincia').value = usuario.provincia ?? '';
                document.getElementById('usuarioRol').value = usuario.rol_id;
            }
        </script>
    </body>
</html>