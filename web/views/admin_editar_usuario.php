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
    <title>Modificar Usuario - Administración</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <div class="container my-5 col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primario text-white">
                <h3 class="mb-0 fs-5">Modificar Usuario: <?= htmlspecialchars($usuarioEditar['nombre']) ?></h3>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="index.php?seccion=usuarios-administracion&accion=editar&id=<?= $usuarioEditar['idUser'] ?>" method="POST" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre de Usuario (Login)</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" value="<?= htmlspecialchars($usuarioEditar['usuario']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contraseña <small class="text-muted">(Déjalo en blanco si no deseas cambiarla)</small></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Nueva contraseña opcional" data-optional-empty>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($usuarioEditar['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= htmlspecialchars($usuarioEditar['apellidos']) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($usuarioEditar['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="<?= htmlspecialchars($usuarioEditar['telefono']) ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($usuarioEditar['fecha_nacimiento']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="Masculino" <?= ($usuarioEditar['sexo'] === 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                <option value="Femenino" <?= ($usuarioEditar['sexo'] === 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                                <option value="Otro" <?= ($usuarioEditar['sexo'] === 'Otro') ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Rol en el Sistema</label>
                            <select name="rol" class="form-select">
                                <option value="user" <?= ($usuarioEditar['rol'] === 'user') ? 'selected' : '' ?>>Usuario</option>
                                <option value="admin" <?= ($usuarioEditar['rol'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($usuarioEditar['direccion']) ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?seccion=usuarios-administracion" class="btn btn-secondary rounded-pill px-4">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-white fw-bold btn-acciones-modificar px-4">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js" defer></script>
</body>
</html>