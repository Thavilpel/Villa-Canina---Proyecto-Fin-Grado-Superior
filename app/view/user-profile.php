<?php $nombreAdmin = $_SESSION['nombre'] ?? ''; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil | <?= htmlspecialchars($usuario['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">

    <h1>Mi Perfil</h1>

    <?php if(!empty($mensaje)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- BOTÓN EDITAR -->
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#perfilModal">Editar Perfil</button>

    <!-- DATOS -->
    <div class="mb-4">
        <img src="../../public/img/avatar/<?= htmlspecialchars($usuario['avatar'] ?? 'default.png') ?>" width="120" class="rounded mb-2">
        <ul class="list-group">
            <li class="list-group-item"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></li>
            <li class="list-group-item"><strong>Apellidos:</strong> <?= htmlspecialchars($usuario['apellidos']) ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></li>
            <li class="list-group-item"><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono'] ?? '-') ?></li>
            <li class="list-group-item"><strong>Dirección:</strong> <?= htmlspecialchars($usuario['direccion'] ?? '-') ?></li>
            <li class="list-group-item"><strong>Ciudad:</strong> <?= htmlspecialchars($usuario['ciudad'] ?? '-') ?></li>
            <li class="list-group-item"><strong>Provincia:</strong> <?= htmlspecialchars($usuario['provincia'] ?? '-') ?></li>
        </ul>
    </div>

    <!-- TABLA SOLICITUDES -->
    <h2>Mis Solicitudes</h2>
    <?php if(!empty($solicitudes)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th><th>Servicio</th><th>Teléfono</th><th>Email</th><th>Descripción</th><th>Fecha</th><th>Cita</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($solicitudes as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['servicio']) ?></td>
                    <td><?= htmlspecialchars($s['telefono']) ?></td>
                    <td><?= htmlspecialchars($s['email']) ?></td>
                    <td><?= htmlspecialchars($s['descripcion']) ?></td>
                    <td><?= $s['fecha_solicitud'] ?></td>
                    <td><?= $s['tiene_cita'] ? 'Sí' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tiene solicitudes.</p>
    <?php endif; ?>

    <!-- TABLA CITAS -->
    <h2>Mis Citas</h2>
    <?php if(!empty($citas)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th><th>Servicio</th><th>Fecha y Hora</th><th>Estado</th><th>Comentario</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($citas as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['servicio']) ?></td>
                    <td><?= $c['fecha_hora'] ?></td>
                    <td><?= htmlspecialchars($c['estado']) ?></td>
                    <td><?= htmlspecialchars($c['comentario']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tiene citas.</p>
    <?php endif; ?>

</div>

<!-- MODAL EDITAR PERFIL -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="editar_perfil" value="1">
                    <div class="mb-3">
                        <label>Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Contraseña (solo si desea cambiarla)</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" value="<?= htmlspecialchars($usuario['ciudad']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Provincia</label>
                        <input type="text" class="form-control" name="provincia" value="<?= htmlspecialchars($usuario['provincia']) ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
