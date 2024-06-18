<?php
    include("modelo/tablaAdminDAO.php");
    class tablaAdminControlador{

        // Las funciones index, se encargan de cargar las vistas de la pagina.
        // Si no existe la variable controller por GET, se cargara la vista de la pagina home por defecto.
        // Por contra si existe, se cargara la vista a la que se quiera acceder al llamar a esa funcion index. 

        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'controlador/tablaAdminControlador.php';
                include_once 'modelo/tablaAdminDAO.php';
                include("vista/header.php");
                include_once 'vista/tablaAdmin.php';
                include("vista/footer.php");
            }
        }

        public static function indexPedidoUsuario(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                // Si existe un idCliente de sesion, se crea un array con todos los pedidos realizados por el cliente que ha iniciado sesion.
                // Este sistema se usara en la mayoria de funciones index con el objetivo de poder tratar con la informacion obtenida mediante las funciones
                if(isset($_SESSION['idCliente'])){
                    $misPedidos = tablaAdminDAO::getAllMisPedidos($_SESSION['idCliente']);
                }
                // Posteriormente se carga la vista
                include_once 'config/dataBase.php';
                include("vista/header.php");
                include_once 'vista/pedidosUsuario.php';
                include("vista/footer.php");
            }
        }

        public static function indexModificar(){
          
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'controlador/tablaAdminControlador.php';
                include_once 'modelo/tablaAdminDAO.php';
                include_once 'vista/header.php';
                if(isset($_POST['escondidoModificar'])){
                    $productoUpdate = productoDAO::getProductoById($_POST['escondidoModificar']);   
                }
                include_once 'vista/modificarProducto.php';
            }
        }

        public static function indexAñadir(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'controlador/tablaAdminControlador.php';
                include_once 'modelo/tablaAdminDAO.php';
                include_once 'vista/header.php';
                include_once 'vista/añadirProducto.php';
                include_once 'vista/footer.php';
            }
        }

        public static function indexAñadirUsuario(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'vista/header.php';
                include_once 'vista/añadirUsuario.php';
                include("vista/seccionInfoEnvio.php");
                include_once 'vista/footer.php';
            }
        }

        public static function indexPanelPedidosAdmin(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'modelo/tablaAdminDAO.php';
                include_once 'controlador/tablaAdminControlador.php';
                include("vista/header.php");
                $pedidos = tablaAdminDAO::getAllPedidos();
                include_once 'vista/panelPedidosAdmin.php';
                include("vista/footer.php");
            }
        }

        public static function indexPanelProductosAdmin(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'modelo/tablaAdminDAO.php';
                include_once 'controlador/tablaAdminControlador.php';
                include("vista/header.php");
                $products = tablaAdminDAO::getAllProducts();
                include_once 'vista/panelProductosAdmin.php';
                include("vista/footer.php");
            }
        }

        public static function indexPanelUsuariosAdmin(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                if(isset($_SESSION['idCliente'])){
                    $usuarios = tablaAdminDAO::obtenerInfoUsuariosAdmin();
                }
                include_once 'config/dataBase.php';
                include_once 'modelo/tablaAdminDAO.php';
                include_once 'controlador/tablaAdminControlador.php';
                include("vista/header.php");
                include_once 'vista/panelUsuariosAdmin.php';
                include("vista/footer.php");
            }
        }
        
        // Funcion para insertar productos
        public static function procesarFormularioInsertar(){
            // Cuando se envia la informacion a traves del formulario, la funcion insertarProducto evisa los datos al DAO
            tablaAdminControlador::insertarProducto(
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['precioUnitario'],
                $_POST['categoria'],
                $_POST['img']
            );
        }

        public static function procesarFormularioModificar(){
                // Al recibir la informacion del formulario, se envian los datos al DAO para trabajar con la BBDD
                tablaAdminDAO::modificar(
                    $_POST['nombre'],
                    $_POST['descripcion'],
                    $_POST['precioUnitario'],
                    $_POST['categoria'],
                    $_POST['img'],
                    $_POST['escondidoModificar']
                );
                // Despues se redirecciona a la vista de la tabla del administrador
                header("Location:".URL."?controller=tablaAdmin&action=indexPanelProductosAdmin");          
        }
    
        public static function insertarProducto($nombre, $descripcion, $precio, $categoria, $img){
            // Si se ha enviado esta informacion por el formulario, se llama a la funcion de insertar del DAO, a la cual se le pasa dicha informacion
            if(isset($_POST['btnInsertar'])  && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precioUnitario']) && isset($_POST['categoria']) && isset($_POST['img'])){
                tablaAdminDAO::insertar($nombre, $descripcion, $precio, $categoria, $img);
                // Redireccionamos a otra vista
                header("Location:".URL."?controller=tablaAdmin&action=indexPanelProductosAdmin");
            }
        }
    
        public static function eliminarProducto(){
                // Asignamos el valor de un input hidden a la variable id para poder guardar el id del producto que se desea eliminar
                $id = $_POST['escondido'];
                // Llamamos a la funcion DAO que realizara la consulta para eliminar el producto con el ID que le pasemos
                tablaAdminDAO::eliminar($id);
                // Redireccionamos la pagina a otra vista
                header("Location:".URL."?controller=tablaAdmin&action=indexPanelProductosAdmin");
        }
    
        public static function modificarProducto($nombre, $descripcion, $precio, $categoria, $img, $id){
            // Si se han enviado todos los campos del formulario, se llama a la funcion DAO de modificar
            if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['precioUnitario']) && isset($_POST['categoria']) && isset($_POST['img'])){
                tablaAdminDAO::modificar($nombre, $descripcion, $precio, $categoria, $img, $id);
                // Redireccionamos a la vista de la tabla del administrador
                header("Location: tablaAdmin.php");
            }
        }

        public static function eliminarPedido(){
            // Guardamos el id del pedido con un input hidden y en la variable id
            $id = $_POST['escondidoPedido'];
            // Le pasamos el id a la funcion DAO para eliminar pedidos
            tablaAdminDAO::deletePedido($id);
            // Una vez realizada la consulta, volvemos al panel de pedidos del administrador
            header("Location:".URL."?controller=tablaAdmin&action=indexPanelPedidosAdmin");
        }

        public static function eliminarUsuario(){
            // Guardamos el id del usuario que queremos eliminar
            $id = $_POST['escondidoUsuario'];
            // Le pasamos el id a la funcion que elimina usuarios
            tablaAdminDAO::deleteUsuario($id);
            // Redireccionamos a la vista 
            header("Location:".URL."?controller=tablaAdmin&action=indexPanelUsuariosAdmin");
        }

        public static function crearUsuario(){
            // Si se han rellenado los campos que se piden, se hara lo siguiente:
            if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['rol']) && isset($_POST['contraseña']) && isset($_POST['btnCrearUsuario'])){
                // Declaramos las variables que contendran los valores enviados a traves del formulario
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $correo_electronico = $_POST['email'];
                $rol = $_POST['rol'];
                $contraseña = $_POST['contraseña'];
                // Cremaos una contraseña cifrada con la contraseña que se ha enviado por el formulario
                $contraseñaCifradaUsuario = password_hash($contraseña, PASSWORD_DEFAULT);
                // Si se ha seleccionado el input sr, el genero del usuario sera hombre
                if(isset($_POST['sr'])){
                    $genero = 'Hombre';
                // Si se ha seleccionado el input sra, el genero sera mujer
                }else if(isset($_POST['sra'])){
                    $genero = 'Mujer';
                // Si no se ha seleccionado nada, el campo de la BBDD sera null
                }else{
                    $genero = null;
                }
                // Con toda la informacion lista, se la pasamos a la funcion DAO que se encargara de realizar el registro
                $registroUser = registroDAO::insertarCliente($nombre, $apellido, $genero, $correo_electronico, $rol, $contraseñaCifradaUsuario);
                // Si no se ha realizado el insert, se vuelve a la vista de añadir usuarios
                if($registroUser){
                    header("Location:".URL."?controller=tablaAdmin&action=indexAñadirUsuario");
                // Si se ha añadido, se vuelve al panel de usuarios del administrador
                }else{
                    header("Location:".URL."?controller=tablaAdmin&action=indexPanelUsuariosAdmin");
                }
            }  
        }

        public static function indexModificarUsuario() {
            if (!isset($_GET['controller'])) {
                include_once 'vista/cuerpo.php';
            } else {
                if (isset($_POST['escondidoModificarUsuario'])) {
                    $idUsuarioModificar = $_POST['escondidoModificarUsuario'];
                    $usuarioAmodificar = tablaAdminDAO::obtenerInfoUsuarioAdminById($idUsuarioModificar);
        
                    // Verificamos si el usuario fue encontrado
                    if ($usuarioAmodificar) {
                        include_once 'config/dataBase.php';
                        include_once 'vista/header.php';
                        include_once 'vista/modificarUsuario.php';
                        include("vista/seccionInfoEnvio.php");
                        include_once 'vista/footer.php';
                    // Si no existe se imprime el siguiente mensaje
                    } else {
                        echo "Usuario no encontrado"; 
                    }
                }
            }
        }
        
        public static function procesarFormularioModificarUsuarioAdmin(){
            // Si se envia alguno de los siguiente campos a traves del formulario, se hara lo siguiente
            if(isset($_POST['nombre']) || isset($_POST['apellido']) || isset($_POST['email']) || isset($_POST['rol']) || (isset($_POST['contraseña']) && isset($_POST['nuevaCotraseña'])) && isset($_SESSION['idCliente'])){
                // Asignamos los valores de los campos a cada una de las siguientes variables
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $correo = $_POST['email'];
                $rol = $_POST['rol'];
                // Si el valor del campo contraseña es igual al valor del campo de la nueva contraseña, a la variable contraseña se le asigna el valor de la nueva contraseña 
                if($_POST['contraseña'] == $_POST['nuevaContraseña']){
                    $contraseña = $_POST['nuevaContraseña'];
                // Si no, se recarga la vista
                }else{
                    header("Location:".URL."?controller=tablaAdmin&action=indexModificarUsuario");
                    exit;
                }
                // Si la variable contraseña no esta vacia, se guarda la contraseña encriptada en una variable
                if (!empty($contraseña)) {
                    $nuevaContraEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);
                // Si no, almacenamos el id del cliente y se mantiene la contraseña por defecto que ya estaba guardada
                }else{
                    $usuarioActualizar = actualizarUsuarioDAO::obtenerInfoUsuario($_SESSION['idCliente']);
                    $nuevaContraEncriptada = $usuarioActualizar->getContraseña();
                }

                // Si se ha seleccionado el input sr, el genero sera hombre
                if(isset($_POST['sr'])){
                    $genero = "Hombre";
                // Si no es asi y se ha seleccionado el input sra, el genero sera mujer
                }else if(isset($_POST['sra'])){
                    $genero = "Mujer";
                // Y si no se ha seleccionado ninguno de los dos, sera null
                }else{
                    $genero = null;
                }
                // Guardamos el id del cliente
                $idCliente = $_POST['idHidden'];
                // Le pasamos toda la informacion a la funcion DAO que se encargara de actualizar el usuario 
                tablaAdminDAO::actualizarUsuarioAdmin($nombre, $apellido, $correo, $rol, $genero, $nuevaContraEncriptada, $idCliente);
            }
            // Al final, se redirecciona la vista de nuevo
            header("Location:".URL."?controller=tablaAdmin&action=indexPanelUsuariosAdmin");          
        }
    }
?>