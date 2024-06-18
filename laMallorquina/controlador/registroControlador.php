<?php
    include('modelo/registroDAO.php');

    class registroControlador{

        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include('vista/header.php');
                include_once 'vista/registro.php';
                include("vista/seccionInfoEnvio.php");
                include('vista/footer.php');
            }
        }

        // Funcion para registrar usuarios
        public static function registrar(){
            // Si se ha enviado la siguiente informacion a traves del formulario, se hara lo siguiente:
            if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['contraseña']) && isset($_POST['suscribirse']) && isset($_POST['tratoDatos']) && isset($_POST['btnRegistrar'])){
                // Guardamos el valor de los inputs en variables
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $correo_electronico = $_POST['email'];
                $rol = 'Cliente';
                $contraseña = $_POST['contraseña'];
                // Creamos la contraseña cifrada
                $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
                // Guardamos el genero del usuario segun el tipo de input radio que haya seleccionado. Y si no ha seleccionado ninguno, el campo sera null
                if(isset($_POST['sr'])){
                    $genero = 'Hombre';
                }else if(isset($_POST['sra'])){
                    $genero = 'Mujer';
                }else{
                    $genero = null;
                }
                // Realizamos la consulta para añadir el nuevo usuario a la base de datos
                $registroUser = registroDAO::insertarCliente($nombre, $apellido, $genero, $correo_electronico, $rol, $contraseñaCifrada);
                // Si la consulta no se ha realizado, se vuelve a la pagina de registro
                if($registroUser){
                    header("Location:".URL."?controller=registro");
                // Si se ha realizado correctamente, se redirecciona a la pagina de inicio
                }else{
                    header("Location:".URL."?controller=inicioSesion");
                }
            }  
        }
    }
?>