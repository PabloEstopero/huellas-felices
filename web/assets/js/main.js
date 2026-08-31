//AUTO-CIERRE DE ALERTA-home.php
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function() {
        const alerta = document.getElementById('alertaBienvenida');
        if (alerta) {
            let bsAlert = new bootstrap.Alert(alerta);
            bsAlert.close();
        }
    }, 3500);
});


/**
 * ==========================================================================
 * SCRIPT MAESTRO: VALIDACIÓN DE FORMULARIOS (REGISTRO Y ADMIN)
 * ==========================================================================
 */
document.addEventListener('DOMContentLoaded', function() {
    const regexMap = {
        'nombre': /^[A-ZÁÉÍÓÚÑ]/u,
        'apellidos': /^[A-ZÁÉÍÓÚÑ]/u,
        'email': /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        'telefono': /^[0-9\s\-\+]{9,15}$/,
        'usuario': /.+/,
        'password': /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/
    };

    Object.keys(regexMap).forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            // 1. Pre-validación al cargar (útil para edición en admin)
            if (input.value.trim() !== '') {
                if (regexMap[id].test(input.value)) {
                    input.classList.add('is-valid');
                }
            }

            // 2. Validación en tiempo real al perder el foco (blur)
            input.addEventListener('blur', function() {
                // Si es contraseña y está vacía en un formulario (ej. editar usuario), la ignoramos
                if (id === 'password' && input.value.trim() === '' && input.hasAttribute('data-optional-empty')) {
                    input.classList.remove('is-valid', 'is-invalid');
                    return;
                }

                const regex = regexMap[id];
                if (regex.test(input.value)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            });
        }
    });
});



// GESTIÓN DE MODAL DE BORRADO - CITAS ADMIN

document.addEventListener('DOMContentLoaded', function() {
    const modalBorrarAdmin = document.getElementById('modalBorrarAdmin');
    
    if (modalBorrarAdmin) {
        modalBorrarAdmin.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idCita = button.getAttribute('data-id-admin');
            const btnConfirmar = document.getElementById('btnConfirmarBorrarAdmin');
            
            if (btnConfirmar && idCita) {
                btnConfirmar.setAttribute('href', 'index.php?seccion=citas-administracion&accion=borrar&id=' + idCita);
            }
        });
    }
});


//GESTIÓN DE MODAL DE BORRADO DE NOTICIAS (ADMINISTRACIÓN)

document.addEventListener('DOMContentLoaded', function() {
    const modalBorrarNoticia = document.getElementById('modalBorrarNoticia');

    if (modalBorrarNoticia) {
        modalBorrarNoticia.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idNoticia = button.getAttribute('data-id-noticia');
            const btnConfirmar = document.getElementById('btnConfirmarBorrarNoticia');

            if (btnConfirmar && idNoticia) {
                btnConfirmar.setAttribute('href', 'index.php?seccion=noticias-administracion&accion=borrar&id=' + idNoticia);
            }
        });
    }
});

//GESTIÓN DE MODAL DE BORRADO DE USUARIOS (ADMINISTRACIÓN)

document.addEventListener('DOMContentLoaded', function () {
    const modalBorrar = document.getElementById('modalBorrar');
    if (modalBorrar) {
        modalBorrar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idUsuario = button.getAttribute('data-id');
            const btnConfirmar = document.getElementById('btnConfirmarBorrar');
            btnConfirmar.href = 'index.php?seccion=usuarios-administracion&accion=eliminar&id=' + idUsuario;
        });
    }
});



