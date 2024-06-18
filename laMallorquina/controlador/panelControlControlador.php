<?php
    class panelControlControlador{
        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'controlador/panelControlControlador.php';
                include('vista/header.php');
                include_once 'vista/panelControl.php';
                include("vista/seccionInfoEnvio.php");
                include('vista/footer.php');
            }
        } 
    }
?>