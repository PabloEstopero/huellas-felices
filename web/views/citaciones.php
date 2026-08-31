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
    <title>Mis Citaciones — Proyecto Final</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-5">
        <h2 class="text-teal mb-4 text-center fw-bold">Gestión de Citaciones</h2>

        <!-- Alertas de éxito o error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($exito)): ?>
            <div class="alert alert-success shadow-sm"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- FORMULARIO DE CREACIÓN / EDICIÓN -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primario text-white">
                        <h4 class="mb-0 fs-5">
                            <?= $citaAEditar ? 'Modificar Cita' : 'Solicitar Nueva Cita' ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?seccion=citaciones" method="POST">
                            <input type="hidden" name="accion" value="<?= $citaAEditar ? 'editar' : 'crear' ?>">
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
                                    <?= $citaAEditar ? 'Actualizar Cita' : 'Solicitar Cita' ?>
                                </button>
                                <?php if ($citaAEditar): ?>
                                    <a href="index.php?seccion=citaciones" class="btn btn-secondary rounded-pill mt-1">Cancelar Edición</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLA DE CITAS PLANIFICADAS -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primario text-white">
                        <h4 class="mb-0 fs-5">Mis Citas Registradas</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($citasUsuario)): ?>
                            <p class="text-muted text-center mb-0">No tienes ninguna cita registrada.</p>
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
                                                    <?php if (!$esPasada): ?>
                                                        <a href="index.php?seccion=citaciones&accion=preparar_editar&id=<?= $cita['idCita'] ?>"
                                                            class="btn btn-sm btn-warning mb-1 text-white fw-semibold rounded-pill px-3">Modificar</a>

                                                    <button type="button" class="btn btn-sm btn-danger mb-1 rounded-pill px-3"
                                                        data-bs-toggle="modal" data-bs-target="#modalBorrar"
                                                        data-id="<?= $cita['idCita'] ?>">
                                                        Borrar
                                                    </button>
                                                    <?php else: ?>
                                                        <span class="small text-muted">No modificable</span>
                                                    <?php endif; ?>
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
    </div>

    <!-- MODAL DE CONFIRMACIÓN DE BORRADO-->
    <div class="modal fade" id="modalBorrar" tabindex="-1" aria-labelledby="modalBorrarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalBorrarLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">¿Estás seguro de que deseas eliminar esta cita? Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarBorrar" href="#" class="btn btn-danger rounded-pill px-4">Sí, eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/cita_usuario_borrar.js" defer></script>

</body>
</html>