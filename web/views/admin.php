<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Administración</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-teal mb-0 fw-bold">Gestión de Usuarios</h2>
            <a href="index.php?seccion=usuarios-administracion&accion=crear" class="btn btn-corporativo fw-bold px-4">
                + Crear Nuevo Usuario
            </a>
        </div>

        <!-- Alertas de éxito o error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($exito)): ?>
            <div class="alert alert-success shadow-sm"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header bg-primario text-white">
                <h4 class="mb-0 fs-5">Usuarios Registrados en el Sistema</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario (Login)</th>
                                <th>Nombre y Apellidos</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuariosSistema as $u): ?>
                                <tr>
                                    <td><?= $u['idUser'] ?></td>
                                    <td><?= htmlspecialchars($u['usuario']) ?></td>
                                    <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td>
                                        <?php if ($u['rol'] === 'admin'): ?>
                                            <span class="badge bg-danger badge-admin">Administrador</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary badge-usuario">Usuario</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Botón Modificar -->
                                        <a href="index.php?seccion=usuarios-administracion&accion=editar&id=<?= $u['idUser'] ?>" 
                                            class="btn btn-sm btn-warning text-white fw-semibold me-1 mb-1 btn-acciones-modificar">
                                            Modificar
                                        </a>

                                        <!-- Botón Eliminar con Modal de Bootstrap -->
                                        <?php if ($u['idUser'] !== $_SESSION['user_id']): ?>
                                            <button type="button" class="btn btn-sm btn-danger mb-1 rounded-pill px-3"
                                                data-bs-toggle="modal" data-bs-target="#modalBorrar"
                                                data-id="<?= $u['idUser'] ?>">
                                                Eliminar
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted small d-block">Tu cuenta</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL DE BORRADO DE USUARIOS -->
        <div class="modal fade" id="modalBorrar" tabindex="-1" aria-labelledby="modalBorrarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalBorrarLabel">Confirmar eliminación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">¿Estás seguro de que deseas eliminar este usuario del sistema?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <a id="btnConfirmarBorrar" href="#" class="btn btn-danger rounded-pill px-4">Sí, eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    <!-- PIE DE PÁGINA-->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js" defer></script>
</body>

</html>