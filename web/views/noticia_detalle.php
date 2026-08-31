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
    <title>Huellas Felices — <?= isset($noticia['titulo']) ? htmlspecialchars($noticia['titulo']) : 'Detalle de Noticia' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">
    
    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    
    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Botón para volver atrás -->
                <a href="index.php?seccion=noticias" class="btn btn-outline-secondary mb-4 rounded-pill px-4">&larr; Volver al listado</a>

                <?php if (empty($noticia)): ?>
                    <div class="alert alert-warning text-center shadow-sm">La noticia solicitada no existe o ha sido eliminada.</div>
                <?php else: ?>
                    <!-- Tarjeta contenedora de la noticia individual -->
                    <div class="card shadow-sm p-4 bg-white border-0">
                        <h1 class="text-teal fw-bold mb-3"><?= htmlspecialchars($noticia['titulo']) ?></h1>
                        
                        <p class="text-muted small mb-4 border-bottom pb-2">
                            Publicado el <?= htmlspecialchars($noticia['fecha']) ?> por <strong><?= htmlspecialchars($noticia['autor_nombre'] ?? 'Administración') ?></strong>
                        </p>

                        <!-- Imagen destacada grande -->
                        <?php if (!empty($noticia['imagen'])): ?>
                            <div class="mb-4 text-center">
                                <img src="<?= htmlspecialchars($noticia['imagen']) ?>" class="detalle-imagen img-fluid rounded shadow-sm" alt="Imagen de la noticia">
                            </div>
                        <?php endif; ?>

                        <!-- Texto completo de la noticia -->
                        <div class="text-secondary texto-noticia-detalle">
                            <?= 
                            
                                nl2br(htmlspecialchars($noticia['texto'])) 
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices — Proyecto Final</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>