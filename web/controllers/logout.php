<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Vaciamos todas las variables de sesión
$_SESSION = array();

# Destruimos la sesión en el servidor
session_destroy();

# Redirigimos al usuario al inicio (o al login)
header('Location: index.php');
exit;
?>