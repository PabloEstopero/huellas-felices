<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$seccionActual = $_GET['seccion'] ?? 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm navbar-corporativa">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="index.php">
            <!-- Logotipo Circular SVG -->
            <div >
                <img src="assets/img/logo.svg" alt="Icono de perrito" width="30">
            </div>
            <span class="tracking-wide">HUELLAS FELICES</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                
                <!-- ENLACE INICIO -->
                <li class="nav-item">
                    <a class="nav-link <?= ($seccionActual === 'home' || $seccionActual === '') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php">INDEX</a>
                </li>

                <!-- ENLACE NOTICIAS -->
                <li class="nav-item">
                    <a class="nav-link <?= ($seccionActual === 'noticias') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=noticias">NOTICIAS</a>
                </li>

                <!-- SI HAY UNA SESIÓN INICIADA -->
                <?php if (!empty($_SESSION['user_id'])): ?>
                    
                    <!-- Menú para USUARIO NORMAL -->
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'citaciones') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=citaciones">CITACIONES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'perfil') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=perfil">PERFIL</a>
                        </li>
                    <?php endif; ?>

                    <!-- Menú para ADMINISTRADOR -->
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'usuarios-administracion') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=usuarios-administracion">USUARIOS-ADMINISTRACION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'citas-administracion') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=citas-administracion">CITACIONES-ADMINISTRACION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'noticias-administracion') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=noticias-administracion">NOTICIAS-ADMINISTRACION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($seccionActual === 'perfil') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=perfil">PERFIL</a>
                        </li>
                    <?php endif; ?>

                    <!-- CERRAR SESIÓN -->
                    <li class="nav-item ms-3">
                        <a class="nav-link text-danger fw-bold" href="index.php?seccion=logout">CERRAR SESIÓN</a>
                    </li>

                <?php else: ?>
                    <!-- SI ES VISITANTE -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccionActual === 'login') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=login">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($seccionActual === 'registro') ? 'active text-warning fw-bold' : 'text-white' ?>" href="index.php?seccion=registro">REGISTRO</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>