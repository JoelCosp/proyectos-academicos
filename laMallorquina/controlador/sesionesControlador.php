<?php
    // Verificamos el estado de la sesion actual y si no se ha iniciado ninguna, se crea una nueva
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Si la variable de sesion lista no existe, se crea   
    if (!isset($_SESSION['lista'])) {
        $_SESSION['lista'] = array();
    }
?>