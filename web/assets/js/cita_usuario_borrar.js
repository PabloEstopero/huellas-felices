// ==========================================
// GESTIÓN DE MODAL DE BORRADO DE CITAS (USUARIO)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const modalBorrar = document.getElementById('modalBorrar');
    
    if (modalBorrar) {
        modalBorrar.addEventListener('show.bs.modal', function (event) {
            // Botón que ha abierto el modal
            const button = event.relatedTarget;
            
            // Extraemos el id de la cita del atributo data-id
            const idCita = button.getAttribute('data-id');
            
            // Localizamos el botón de confirmación dentro del modal
            const btnConfirmar = document.getElementById('btnConfirmarBorrar');
            
            if (btnConfirmar && idCita) {
                // Asignamos la ruta exacta hacia el controlador de citaciones
                btnConfirmar.setAttribute('href', 'index.php?seccion=citaciones&accion=borrar&id=' + idCita);
            }
        });
    }
});