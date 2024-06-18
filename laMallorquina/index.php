<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Añadimos todos los includes necesarios para poder usar los controladores de cada pagina 

    include("config/parameters.php");
    include("controlador/cuerpoControlador.php");
    include("controlador/productoControlador.php");
    include("controlador/inicioSesionControlador.php");
    include("controlador/registroControlador.php");
    include("controlador/carritoControlador.php");
    include("controlador/sesionesControlador.php");
    include("controlador/tablaAdminControlador.php");
    include("controlador/pedidoControlador.php");
    include("controlador/actualizarUsuarioControlador.php");
    include("controlador/panelControlControlador.php");
    include("controlador/reseñasControlador.php");
    include("controlador/apiControlador.php");

    // Punto de entrada principal a la aplicacion

    // Si no existe la variable controller pasada por get, se llama al controlador de la pagina principal 
    if(!isset($_GET['controller'])) {
        header("Location:" . URL . "?controller=cuerpo");
    } else {
        // Si existe, se declara una variable con el valor del controller y se le concatena la palabra Controlador, para que coincida con el nombre del archivo PHP
        $nombre_controller = $_GET['controller'] . "Controlador";

        // Si la classe de dicho controlador existe, se crea un objeto
        if(class_exists($nombre_controller)) {
            $controller = new $nombre_controller;

            // Si existe el valor de action pasado por get, se declara la variable action con su valor
            if(isset($_GET['action'])) {
                $action = $_GET['action'];
            } else {
                // Y si no existe, se declara con la accion por defecto del archivo parameters, que es index
                $action = action_default;
            }

            // Invocamos dinamicamente la accion del controlador
            $controller->$action();

        } else {
            // Si no existe la clase, se carga la pagina del cuerpo, que llamara a la accion index por defecto
            header("Location:".URL."?controller=cuerpo");
        }
    }
?>