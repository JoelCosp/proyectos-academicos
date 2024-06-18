<?php
    class cuerpoControlador{
        public function index(){
            include_once 'vista/header.php';
            include_once 'vista/cuerpo.php';
            include("vista/seccionInfoEnvio.php");
            include('vista/footer.php');
        }
    }
?>