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
    <title>Huellas Felices — Noticias</title>

    <link rel="stylesheet" href="assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    
    <!-- HERO SUPERIOR CON TÍTULOS DE NOTICIAS -->
    <div class="hero-protectora text-center mb-5">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Actualidad de la Protectora</h1>
            <p class="lead mb-4">Descubre nuestros últimos rescates, historias de adopción y avisos importantes.</p>

            <?php if (!empty($noticias)): ?>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <p class="small text-uppercase fw-bold text-light mb-2">Noticias destacadas (Haz clic para leer):</p>
                        <div class="hero-news-links shadow-sm">
                            <?php foreach ($noticias as $n): ?>
                                <a href="index.php?seccion=ver_noticia&id=<?= $n['idNoticia'] ?>" class="hero-news-item text-truncate">
                                    🐾 <?= htmlspecialchars($n['titulo']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mb-5" id="listado-noticias">
        <h2 class="mb-4 text-center text-teal fw-bold">Todas las Publicaciones</h2>

        <?php if (empty($noticias)): ?>
            <div class="alert alert-warning text-center shadow-sm">
                No hay noticias publicadas en este momento.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($noticias as $noticia): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            
                            <!-- Imagen de la noticia -->
                            <img src="<?= htmlspecialchars($noticia['imagen']) ?>" class="card-img-top noticia-card-img" alt="Imagen de noticia">
                            
                            <div class="card-body d-flex flex-column">
                                <!-- Título de la noticia -->
                                <h5 class="card-title text-teal fw-bold"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                                
                                <!-- Fecha y Autor -->
                                <p class="text-muted small mb-2">
                                    Publicado el <?= htmlspecialchars($noticia['fecha']) ?> por <strong><?= htmlspecialchars($noticia['autor_nombre'] ?? 'Administración') ?></strong>
                                </p>

                                <!-- Texto de la noticia (resumen) -->
                                <p class="card-text text-secondary flex-grow-1">
                                    <?= htmlspecialchars(substr($noticia['texto'], 0, 120)) ?>...
                                </p>

                                <a href="index.php?seccion=ver_noticia&id=<?= $noticia['idNoticia'] ?>" class="btn btn-corporativo mt-3 w-100">Leer noticia completa</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>