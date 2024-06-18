<?php
    include("modelo/actualizarUsuarioDAO.php");
    class actualizarUsuarioControlador{
        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'vista/header.php';
                if(isset($_SESSION['idCliente'])){
                    $usuario = actualizarUsuarioDAO::obtenerInfoUsuario($_SESSION['idCliente']);
                }
                include_once 'vista/actualizarUsuario.php';
                include("vista/seccionInfoEnvio.php");
                include_once 'vista/footer.php';
            }
        }

        // Funcion para modificar los datos de un usuario
        public static function procesarFormularioModificarUsuario(){
            // Si se pasa informacion a traves de alguno de los campos del formulario, se hace lo siguiente:  
            if(isset($_POST['nombre']) || isset($_POST['apellido']) || isset($_POST['email']) || (isset($_POST['contraseña']) && isset($_POST['nuevaContraseña'])) && isset($_SESSION['idCliente'])){
                // Inicializamos las siguientes variables con los valores de los inputs
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $correo = $_POST['email'];
                // Procesamos las contraseñas para cifrarlas y registrarlas correctamente 
                if($_POST['contraseña'] == $_POST['nuevaContraseña']){
                    $contraseña = $_POST['nuevaContraseña'];
                }else{
                    //header("Location:".URL."?controller=actualizarUsuario");
                    //exit;
                }
                
                if (!empty($contraseña)) {
                    $nuevaContraEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);
                }else{
                    $usuarioActualizar = actualizarUsuarioDAO::obtenerInfoUsuario($_SESSION['idCliente']);
                    // Si no se proporciona una nueva contraseña, mantener la existente
                    $nuevaContraEncriptada = $usuarioActualizar->getContraseña();
                }
                // Almacenamos el genero del usuario
                if(isset($_POST['sr'])){
                    $genero = "Hombre";
                }else if(isset($_POST['sra'])){
                    $genero = "Mujer";
                }else{
                    $genero = null;
                }
                // Guardamos el id del cliente
                $id = $_SESSION['idCliente'];
                // Le pasamos los valores necesarios a la funcion DAO que se encargara de actualizar el usuario en la BBDD 
                actualizarUsuarioDAO::actualizarUsuario($nombre, $apellido, $correo, $genero, $nuevaContraEncriptada, $id);
            }
            // Cargamos la vista del inicio de sesion
            header("Location:".URL."?controller=actualizarUsuario");          
        }
    }
?>