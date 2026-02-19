<!-- PHP -->
<?php
$nombreAdmin = $_SESSION['nombre'] ?? '';
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil | <?= htmlspecialchars($usuario['nombre']) ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link CSS -->
    <link rel="stylesheet" href="../../public/css/estilo_perfil.css">


</head>
<body class="perfil">

<div class="contenedor">

    <h1 id="h1perfil">Mi Perfil</h1>

    <?php if(!empty($mensaje)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- DATOS -->
    <div class="perfil-usuario" data-bs-toggle="modal" data-bs-target="#perfilModal">
        <img src="../../public/img/avatar/<?= htmlspecialchars($usuario['avatar'] ?? 'default.png') ?>" width="120" class="rounded mb-2">
        <ul class="tabla-perfil">
            <li><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></li>
            <li><strong>Apellidos:</strong> <?= htmlspecialchars($usuario['apellidos']) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></li>
            <li><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono'] ?? '-') ?></li>
            <li><strong>Dirección:</strong> <?= htmlspecialchars($usuario['direccion'] ?? '-') ?></li>
            <li><strong>Ciudad:</strong> <?= htmlspecialchars($usuario['ciudad'] ?? '-') ?></li>
            <li><strong>Provincia:</strong> <?= htmlspecialchars($usuario['provincia'] ?? '-') ?></li>
        </ul>
    </div>

    <!-- BOTÓN EDITAR -->
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#perfilModal">Editar Perfil</button>
    
    <!-- BOTÓN DE CANCELAR DEBAJO DE LA TABLA -->
        <button class="btn btn-warning mb-4" data-bs-toggle="modal" data-bs-target="#cancelarCitaModal">
            Cancelar Cita
        </button>

    <!-- BOTÓN VOLVER -->
    <a href="../../index.php"><button class="btn btn-secondary mb-4">Volver</button></a>

    <!-- TABLA SOLICITUDES -->
    <h2>Mis Solicitudes</h2>
    <?php if(!empty($solicitudes)): ?>
        <table class="tabla-estilo">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Cita</th>
                    <th>Acciones</th> 
                </tr>
            </thead>
            <tbody>
            <?php foreach($solicitudes as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['servicio']) ?></td>
                    <td><?= htmlspecialchars($s['descripcion']) ?></td>
                    <td><?= $s['fecha_solicitud'] ?></td>
                    <td><?= $s['tiene_cita'] ? 'Sí' : 'No' ?></td>
                    <td>
                        <?php if(!$s['tiene_cita']): ?>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres cancelar esta solicitud?');">
                            <input type="hidden" name="action" value="cancelar">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                        </form>
                        <?php else: ?>
                            <span class="text-muted">No se puede cancelar</span>
                        <?php endif; ?>
                    </td>
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
        <table class="tabla-estilo">
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

<!-- MODAL DE CANCELAR CITA -->
<div class="modal fade" id="cancelarCitaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Cancelar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>Para cancelar tu cita, contacta con nosotros a través de:</p>
                <p class="fw-bold">› contacto@villacanina.com ‹</p>
                <p class="fw-bold">› 900 090 239 ‹</p>
                <p>❤️ Sin compromiso ❤️</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
