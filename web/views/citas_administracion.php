<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$hoy = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas (Admin) — Proyecto Final</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <div class="container my-5">
        <h2 class="text-teal mb-4 text-center fw-bold">Panel de Administración: Gestión de Citaciones</h2>

        <!-- Alertas -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($exito)): ?>
            <div class="alert alert-success shadow-sm"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <!-- SELECTOR DE USUARIO -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="GET" action="index.php" class="row align-items-end">
                    <input type="hidden" name="seccion" value="citas-administracion">
                    <div class="col-md-9">
                        <label for="idUser" class="form-label fw-bold">Seleccionar Usuario:</label>
                        <select name="idUser" id="idUser" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Elige un usuario para ver y gestionar sus citas --</option>
                            <?php foreach ($usuariosSistema as $u): ?>
                                <option value="<?= $u['idUser'] ?>" <?= ($idUserSeleccionado === (int)$u['idUser']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($u['nombre'] . ' ' . $u['apellidos'] . ' (' . $u['usuario'] . ')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-secondary w-100 rounded-pill">Cargar Citas</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($idUserSeleccionado > 0): ?>
            <div class="row">
                <!-- FORMULARIO CREAR / EDITAR CITA PARA EL USUARIO -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primario text-white">
                            <h4 class="mb-0 fs-5">
                                <?= $citaAEditar ? 'Modificar Cita de Usuario' : 'Crear Cita para Usuario' ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="index.php?seccion=citas-administracion" method="POST" novalidate>
                                <input type="hidden" name="accion" value="<?= $citaAEditar ? 'editar' : 'crear' ?>">
                                <input type="hidden" name="idUser" value="<?= $idUserSeleccionado ?>">
                                <?php if ($citaAEditar): ?>
                                    <input type="hidden" name="idCita" value="<?= $citaAEditar['idCita'] ?>">
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="fecha_cita" class="form-label fw-semibold">Fecha de la Cita</label>
                                    <input type="date" class="form-control" id="fecha_cita" name="fecha_cita"
                                        min="<?= $hoy ?>"
                                        value="<?= $citaAEditar ? htmlspecialchars($citaAEditar['fecha_cita']) : $hoy ?>"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="motivo_cita" class="form-label fw-semibold">Motivo de la Cita</label>
                                    <textarea class="form-control" id="motivo_cita" name="motivo_cita" rows="3"
                                        required><?= $citaAEditar ? htmlspecialchars($citaAEditar['motivo_cita']) : '' ?></textarea>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-corporativo fw-bold">
                                        <?= $citaAEditar ? 'Actualizar Cita' : 'Crear Cita' ?>
                                    </button>
                                    <?php if ($citaAEditar): ?>
                                        <a href="index.php?seccion=citas-administracion&idUser=<?= $idUserSeleccionado ?>" class="btn btn-secondary rounded-pill">Cancelar Edición</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE CITAS DEL USUARIO SELECCIONADO -->
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header text-white" style="background-color: #234e52;">
                            <h4 class="mb-0 fs-5">Citas Asignadas al Usuario</h4>
                        </div>
                        <div class="card-body">
                            <?php if (empty($citasUsuario)): ?>
                                <p class="text-muted text-center mb-0">Este usuario no tiene ninguna cita registrada.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Motivo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($citasUsuario as $cita): ?>
                                                <?php $esPasada = ($cita['fecha_cita'] < $hoy); ?>
                                                <tr class="<?= $esPasada ? 'table-secondary text-muted' : '' ?>">
                                                    <td><?= htmlspecialchars($cita['fecha_cita']) ?></td>
                                                    <td><?= htmlspecialchars($cita['motivo_cita']) ?></td>
                                                    <td>
                                                        <?php if ($esPasada): ?>
                                                            <span class="badge bg-secondary">Realizada / Pasada</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">Pendiente</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?seccion=citas-administracion&idUser=<?= $idUserSeleccionado ?>&accion=preparar_editar&id=<?= $cita['idCita'] ?>"
                                                            class="btn btn-sm btn-warning mb-1 text-white fw-semibold rounded-pill px-3">Modificar</a>

                                                    <button type="button" class="btn btn-sm btn-danger mb-1 rounded-pill px-3"
                                                        data-bs-toggle="modal" data-bs-target="#modalBorrarAdmin"
                                                        data-id-admin="<?= $cita['idCita'] ?>">
                                                        Borrar
                                                    </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center shadow-sm">Por favor, selecciona un usuario en el desplegable superior para ver y administrar sus citas.</div>
        <?php endif; ?>
    </div>

<!-- MODAL DE BORRADO ADMINISTRADOR -->
<div class="modal fade" id="modalBorrarAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar eliminación (Admin)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Estás seguro de eliminar esta cita como administrador? Se borrará sin restricciones de fecha.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <a id="btnConfirmarBorrarAdmin" href="#" class="btn btn-danger rounded-pill px-4">Sí, eliminar</a>
            </div>
        </div>
    </div>
</div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js" defer></script>

    <!-- PIE DE PÁGINA unificado -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>
</body>
</html>