<?php
    include("modelo/inicioSesionDAO.php");
    class inicioSesionControlador{

        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include('vista/header.php');
                include_once 'vista/iniciarSesion.php';
                include("vista/seccionInfoEnvio.php");
                include('vista/footer.php');
            }
        }
        // Funcion para iniciar sesion en la pagina web
        public static function startSession(){
            // Comprobamos que se hayan completado los campos necesarios para realizar el inicio de sesion
            if(isset($_POST['correo']) && isset($_POST['contraseña'])){
                // Guardamos la informacion de los inputs en variables
                $correo = $_POST['correo'];
                $contraseña = $_POST['contraseña'];
                // Pasamos la informacion necesaria a la funcion DAO que se encargara de realizar el inicio de sesion, contrastando la informacion de los inputs con la de la BBDD
                inicioSesionDAO::iniciarSesion($correo, $contraseña);
            }  
        }
    }
?>