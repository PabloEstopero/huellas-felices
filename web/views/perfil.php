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
    <title>Mi Perfil — Proyecto Final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header card-header-primary">
                        <h2 class="card-title mb-0 text-center fs-4">Mi Perfil de Usuario</h2>
                    </div>
                    <div class="card-body p-4">

                        <!-- Mensajes de éxito o error -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($exito)): ?>
                            <div class="alert alert-success shadow-sm"><?= htmlspecialchars($exito) ?></div>
                        <?php endif; ?>

                        <form action="index.php?seccion=perfil" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold">Nombre de Usuario (No se puede cambiar)</label>
                                <input type="text" class="form-control bg-secondary-subtle" value="<?= htmlspecialchars($usuarioData['usuario']) ?>" disabled>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuarioData['nombre']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($usuarioData['apellidos']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuarioData['email']) ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($usuarioData['telefono']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($usuarioData['fecha_nacimiento']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-semibold">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($usuarioData['direccion']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="sexo" class="form-label fw-semibold">Sexo</label>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="Masculino" <?= ($usuarioData['sexo'] === 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino" <?= ($usuarioData['sexo'] === 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                                    <option value="Otro" <?= ($usuarioData['sexo'] === 'Otro') ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-teal mb-3 fw-bold">Seguridad</h5>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Nueva Contraseña <small class="text-muted fw-normal">(déjalo en blanco si no deseas cambiarla)</small></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Introduce nueva contraseña si deseas cambiarla">
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-corporativo btn-lg fw-bold">Guardar Cambios</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/main.js" defer></script>
</body>
</html>