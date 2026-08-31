<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Requerimos el modelo de noticias para mostrar el carrusel en la portada
require_once __DIR__ . '/../models/NoticiasModel.php';
$modeloNoticia = new NoticiaModel();
$noticiasRecientes = $modeloNoticia->obtenerTodas();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellas Felices — Inicio</title>

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

 
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body class="d-flex flex-column min-vh-100">
    
    <!-- BARRA DE NAVEGACIÓN -->
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <!-- MENSAJE DE BIENVENIDA DINÁMICO -->
    <div class="container mt-4">
        <?php if (isset($_SESSION['bienvenida'])): ?>
            <div id="alertaBienvenida" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['bienvenida']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['bienvenida']); ?>
        <?php endif; ?>
    </div>

    <!-- 1. BANNER DE BIENVENIDA (HERO) -->
    <div class="hero-protectora text-center mb-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Protectora Huellas Felices</h1>
            <p class="lead mb-0">Rescatamos, cuidamos y encontramos un hogar lleno de amor para animales abandonados.</p>
        </div>
    </div>

    <div class="container mb-5">

        <!-- 2. CARRUSEL DE NOTICIAS RECIENTES -->
        <?php if (!empty($noticiasRecientes)): ?>
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-10">
                    <h3 class="text-center mb-4 text-dark fw-bold">Últimas Novedades del Refugio</h3>
                    <div id="carruselNoticias" class="carousel slide shadow rounded overflow-hidden" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($noticiasRecientes as $index => $noticia): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($noticia['imagen']) ?>" class="d-block w-100 carrusel-img" alt="Noticia">
                                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-3">
                                        <h5><?= htmlspecialchars($noticia['titulo']) ?></h5>
                                        <p class="small"><?= htmlspecialchars(substr($noticia['texto'], 0, 90)) ?>...</p>
                                        <a href="index.php?seccion=noticias" class="btn btn-sm btn-success">Leer noticia completa</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carruselNoticias" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carruselNoticias" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- 3. SECCIÓN "QUIÉNES SOMOS" -->
        <div class="row align-items-center mb-5 bg-white p-4 rounded shadow-sm">
            <div class="col-md-6">
                <h3 class="text-teal mb-3 fw-bold">Nuestra Misión y Compromiso</h3>
                <p class="text-secondary">
                    En <strong>Huellas Felices</strong> luchamos contra el abandono animal. Cada día rescatamos perros y gatos en situación de vulnerabilidad, ofreciéndoles atención veterinaria completa, alimentación y un espacio seguro mientras encuentran una familia definitiva.
                </p>
                <p class="text-secondary">
                    ¿Te apasionan los animales? Puedes colaborar mediante acogidas temporales, donaciones o solicitando una cita previa para visitarnos y conocer a nuestros peludos.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=800&q=80" alt="Refugio de animales" class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- 4. SECCIÓN UBICACIÓN Y MAPA -->
        <div class="row bg-white p-4 rounded shadow-sm align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <h3 class="text-teal mb-3 fw-bold">¿Dónde Encontrarnos?</h3>
                <p class="text-secondary"><strong>Dirección:</strong> Camino del Refugio s/n, 28001 Madrid</p>
                <p class="text-secondary"><strong>Horario de atención:</strong> Lunes a Sábado de 10:00 a 14:00 (Imprescindible cita previa).</p>
                <p class="text-secondary"><strong>Teléfono de contacto:</strong> +34 912 345 678</p>
                <p class="text-secondary"><strong>Correo electrónico:</strong> <a href="mailto:contacto@huellasfelices.org" class="text-decoration-none text-teal">contacto@huellasfelices.org</a></p>
            </div>
            <div class="col-md-6">
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3037.12658428456!2d-3.703790123456!3d40.4167754!2m3!1f0!2f0!3f0!3m2!1f1024!2f768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDI1JzAwLjQiTiAzwrA0MicyMC42Ilc!5e0!3m2!1ses!2ses!4v1650000000000!5m2!1ses!2ses" width="600" height="450" class="border-0" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

    </div>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center p-3 mt-auto">
        <p>&copy; 2026 Protectora Huellas Felices</p>
    </footer>

    <!-- JS DE BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/main.js" defer></script>
   

</body>

</html>