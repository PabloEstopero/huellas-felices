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
    <title>Proyecto Final — Registro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- CONTENEDOR DEL FORMULARIO -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header card-header-primary text-center">
                        <h2 class="card-title mb-0 fs-4">Registro de Nuevo Usuario</h2>
                    </div>
                    <div class="card-body p-4">

                        <!-- Mensajes de alerta si hay errores o éxito -->
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger shadow-sm">
                            <?= htmlspecialchars($error) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($exito)): ?>
                        <div class="alert alert-success shadow-sm">
                            <?= htmlspecialchars($exito) ?>
                        </div>
                        <?php endif; ?>

                        <!-- Formulario que envía los datos por POST al controlador -->
                        <form action="index.php?seccion=registro" method="POST" novalidate>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        value="<?= htmlspecialchars($datos['apellidos'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($datos['email'] ?? '') ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento"
                                        name="fecha_nacimiento"
                                        value="<?= htmlspecialchars($datos['fecha_nacimiento'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-semibold">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="<?= htmlspecialchars($datos['direccion'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="sexo" class="form-label fw-semibold">Sexo</label>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="">Selecciona una opción...</option>
                                    <option value="Masculino" <?= (isset($datos['sexo']) && $datos['sexo'] === 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino" <?= (isset($datos['sexo']) && $datos['sexo'] === 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                                    <option value="Otro" <?= (isset($datos['sexo']) && $datos['sexo'] === 'Otro') ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-teal mb-3 fw-bold">Datos de Acceso</h5>

                            <div class="mb-3">
                                <label for="usuario" class="form-label fw-semibold">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    value="<?= htmlspecialchars($datos['usuario'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-corporativo btn-lg fw-bold">Registrarse</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
        <p class="mb-0 text-muted">¿Ya tienes cuenta? <a href="index.php?seccion=login" class="text-decoration-none fw-semibold">Inica sesión aquí</a></p>
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