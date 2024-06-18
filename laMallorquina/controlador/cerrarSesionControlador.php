<?php
    include("../config/parameters.php");
    // Este es el archivo que nos permitira cerrar la sesion en nuestro sitio web al pulsar un determinado enlace
    // Creamos la sesion
    session_start();
    // La destruimos para eliminar todas las variables de sesion
    session_destroy();
    // Redireccionamos el sitio web a la pagina home
    header("Location:".URL."?controller=cuerpo");
?>