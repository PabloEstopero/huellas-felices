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
    <title>Administración de Noticias — Proyecto Final</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <div class="container my-5">
        <h2 class="text-teal mb-4 text-center fw-bold">Panel de Administración: Gestión de Noticias</h2>

        <!-- Alertas -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger shadow-sm"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($exito)): ?>
            <div class="alert alert-success shadow-sm"><?= htmlspecialchars($exito) ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- FORMULARIO CREAR / EDITAR NOTICIA -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-header text-white bg-primario">
                        <h4 class="mb-0 fs-5">
                            <?= $noticiaAEditar ? 'Modificar Noticia' : 'Crear Nueva Noticia' ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?seccion=noticias-administracion" method="POST" novalidate>
                            <input type="hidden" name="accion" value="<?= $noticiaAEditar ? 'editar' : 'crear' ?>">
                            <?php if ($noticiaAEditar): ?>
                                <input type="hidden" name="idNoticia" value="<?= $noticiaAEditar['idNoticia'] ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-semibold">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    value="<?= $noticiaAEditar ? htmlspecialchars($noticiaAEditar['titulo']) : '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label fw-semibold">URL de la Imagen</label>
                                <input type="text" class="form-control" id="imagen" name="imagen" placeholder="https://ejemplo.com/imagen.jpg"
                                    value="<?= $noticiaAEditar ? htmlspecialchars($noticiaAEditar['imagen']) : '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="texto" class="form-label fw-semibold">Contenido / Texto</label>
                                <textarea class="form-control" id="texto" name="texto" rows="4" required><?= $noticiaAEditar ? htmlspecialchars($noticiaAEditar['texto']) : '' ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-corporativo fw-bold">
                                    <?= $noticiaAEditar ? 'Actualizar Noticia' : 'Publicar Noticia' ?>
                                </button>
                                <?php if ($noticiaAEditar): ?>
                                    <a href="index.php?seccion=noticias-administracion" class="btn btn-secondary rounded-pill">Cancelar Edición</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLA DE LISTADO DE NOTICIAS -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-white bg-tabla-header" style="background-color: #234e52;">
                        <h4 class="mb-0 fs-5">Noticias Registradas en el Sistema</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($noticias)): ?>
                            <p class="text-muted text-center mb-0">No hay noticias registradas.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Título</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($noticias as $noticia): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="Miniatura" class="miniatura-admin rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                </td>
                                                <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                                                <td><?= htmlspecialchars($noticia['fecha']) ?></td>
                                                <td>
                                                    <a href="index.php?seccion=noticias-administracion&accion=preparar_editar&id=<?= $noticia['idNoticia'] ?>"
                                                        class="btn btn-sm btn-warning mb-1 text-white fw-semibold rounded-pill px-3">Modificar</a>

                                                <button type="button" class="btn btn-sm btn-danger mb-1 rounded-pill px-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalBorrarNoticia"
                                                    data-id-noticia="<?= $noticia['idNoticia'] ?>"> 
                                                    Borrar
                                                </button>
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

    <!-- MODAL DE BORRADO DE NOTICIAS -->
<div class="modal fade" id="modalBorrarNoticia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Estás seguro de que deseas eliminar esta noticia?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <a id="btnConfirmarBorrarNoticia" href="#" class="btn btn-danger rounded-pill px-4">Sí, eliminar</a>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js" defer></script>

    <!-- PIE DE PÁGINA -->
    <footer class="footer-protectora text-center mt-auto p-3">
        <p class="mb-0">&copy; 2026 Protectora Huellas Felices — Proyecto Final</p>
    </footer>
</body>
</html>