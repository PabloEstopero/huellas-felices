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
    <title>Proyecto Final — Iniciar Sesión</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- CONTENEDOR PRINCIPAL DEL LOGIN -->
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header card-header-primary text-center">
                        <h2 class="card-title mb-0 fs-4">Iniciar Sesión</h2>
                    </div>
                    <div class="card-body p-4">

                        <!-- Mensaje de éxito si viene de registrarse -->
                        <?php if (isset($_GET['registrado']) && $_GET['registrado'] === 'success'): ?>
                            <div class="alert alert-success text-center shadow-sm">¡Registro completado con éxito! Ya puedes iniciar sesión.</div>
                        <?php endif; ?>

                        <!-- Mensaje de error si falla el login -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger text-center shadow-sm"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <!-- Formulario de Login -->
                        <form action="index.php?seccion=login" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label fw-semibold">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-corporativo btn-lg fw-bold">Entrar</button>
                            </div>
                        </form>

                        <!-- Enlace para usuarios sin cuenta -->
                        <div class="text-center mt-3">
                            <p class="mb-0 text-muted">¿No tienes cuenta todavía? <a href="index.php?seccion=registro" class="text-decoration-none fw-semibold">Regístrate aquí</a></p>
                        </div>

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
</body>
</html>