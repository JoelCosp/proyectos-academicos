<?php
    include_once 'modelo/productoDAO.php';
    class carritoControlador{
        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'controlador/productoControlador.php';
                include_once 'controlador/pedidoControlador.php';
                include_once 'modelo/productoDAO.php';
                require_once("controlador/sesionesControlador.php");
                include('vista/header.php');
                // Inicializamos la variable del id del ultimo pedido, que de momento sera null
                $idUltimoPedido = null;
                // Si extse la cookie que contiene el precio total del ultimo pedido, haremos lo siguiente
                if(isset($_COOKIE['totalUltimoPedido'])){
                    // La variable de valoresCookie se convertira en un array que contendra los valores de la cadena de la cookie, seprandolos por una coma
                    $valoresCookie = explode(",", $_COOKIE["totalUltimoPedido"]);
                    // Almacenamos los valores del array resultante
                    $idUltimoPedido = $valoresCookie[2];
                    $totalUltimoPedido = $valoresCookie[1];
                    $idUltimoUsuario = $valoresCookie[0];
                    // Si se ha pulsado el boton de cargar el ultimo pedido, se llama a la siguiente funcion
                    if(isset($_POST['btnCargar'])){
                        self::cargarUltimoPedido($idUltimoPedido);
                    }
                }                
                // Almacenamos el valor total del carrito
                $cantidadTotal = carritoControlador::calcularTotal();
                $detallesProductos = array();
                // Obtenemos los detalles de cada producto en el carrito
                foreach ($_SESSION['lista'] as $key => $value) {
                    $producto = productoDAO::getProductoById($_SESSION['lista'][$key]['id']);
                    $detallesProductos[$key] = $producto;
                }
                $productos = $detallesProductos;
                // Cargamos la vista
                include_once 'vista/carrito.php';
                include('vista/footer.php');
            }
        }

        public static function indexGracias(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include('vista/header.php');
                include_once 'vista/agradecimientos.php';
                include('vista/footer.php');
            }
        } 

        public static function indexInfoPedidoApi(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'vista/infoPedidoQr.php';
            }
        } 

        // Funcion para calcular el total del pedido
        public static function calcularTotal(){
            // Inicializamos las siguientes variables
            $total = $_SESSION['lista'];
            $cantidadProducto = 0;
            $sumaPrecio = 0;
            $sumaTotal = 0;
            // Recorremos el array
            foreach ($total as $key => $value) {
                // Almacenamos el producto, la cantidad del producto, la suma del precio y el total
                $producto = productoDAO::getProductoById($_SESSION['lista'][$key]['id']);
                $cantidadProducto = $total[$key]['cantidada'];
                $sumaPrecio = $cantidadProducto * $producto->getPrecioUnidad();
                $sumaTotal = $sumaTotal + $sumaPrecio; 
            } 
            // Se devuelve la suma total
            return $sumaTotal;
        }

        // Funcion para eliminar el rpoducto del carrito
        public static function botonBasura(){
            // Inicializamos la variable con el post de basura, que contiene el id del producto a eliminar
            $idBasura = $_POST['basura'];
            // Recorremos el array donde estan almacenados los productos del carrito
            foreach ($_SESSION['lista'] as $key => $value){
                // Si el array en la posicion key e id es igual al id, se elimina del array
                if($_SESSION['lista'][$key]['id'] == $idBasura){
                    unset($_SESSION['lista'][$key]);   
                    break;   
                }
            }
            // Volvemos a cargar la vista del carrito
            header("Location:".URL."?controller=carrito");
        }

        // Funcion para aumentar la cantidad de los productos que hay en el carrito
        public static function sumarPlaceholder(){
            // Inicializamos la variable con el post de cogerIdArray, que contiene el id del producto
            $idBasura = $_POST['cogerIdArray'];
            // Recorremos el array 
            foreach($_SESSION['lista'] as $key => $value){
                // Si el array en la posicion key e id es igual al id, se le suma 1 al array en la posicion key y cantidada
                if($_SESSION['lista'][$key]['id'] == $idBasura){
                    $_SESSION['lista'][$key]['cantidada'] = $_SESSION['lista'][$key]['cantidada'] + 1;   
                    break;   
                }
            }
            // Volvemos a cargar la vista del carrito
            header("Location:".URL."?controller=carrito");
        }
        
        // Funcion para restar la cantidad de los productos que hay en el carrito
        public static function restarPlaceholder(){
            // Inicializamos la variable con el post de cogerIdArray, que contiene el id del producto
            $idBasura = $_POST['cogerIdArray'];
            // Recorremos el array 
            foreach($_SESSION['lista'] as $key => $value){
                // Si el array en la posicion key e id es igual al id, se le resta 1 al array en la posicion key y cantidada
                if($_SESSION['lista'][$key]['id'] == $idBasura){
                    $_SESSION['lista'][$key]['cantidada'] = $_SESSION['lista'][$key]['cantidada'] - 1;
                    // Y si la cantidad en esa posicion es 0, se elimina del array   
                    if($_SESSION['lista'][$key]['cantidada'] == 0){
                        unset($_SESSION['lista'][$key]);
                    }
                }
            }
            // Volvemos a cargar la vista del carrito
            header("Location:".URL."?controller=carrito");
        }  
        
        // Funcion que ejecuta las funciones de sumar y restar del carrito dependiendo del input de tipo submit que se pulse 
        public static function panelSumaResta(){
            if(isset($_POST['sumarPlaceholder'])){
                self::sumarPlaceholder();
            }else if(isset($_POST['restarPlaceholder'])){
                self::restarPlaceholder();
            }
        }

        // Funcion para cargar el ultimo pedido
        public static function cargarUltimoPedido(){
            // Si existen tanto la cookie con el total del ultimo pedido, como la variable de sesion lista, se hace lo siguiente:
            if(isset($_COOKIE['totalUltimoPedido']) && isset($_SESSION['lista'])){
                // Recorremos el array que contiene los productos del carrito
                foreach ($_SESSION['lista'] as $clave => $subArray) {
                    // Si el elemento iterado es un arrat, se elimina del carrito
                    if (is_array($subArray)) {
                        unset($_SESSION['lista'][$clave]);
                    }
                }
                // Ahora, si el array lista esta vacio, hacemos lo siguiente:
                if(empty($_SESSION['lista'])){
                    // Guardamos los elementos de la cookie en una variable y mediante la funcion explode
                    $elementosCookie = explode(",", $_COOKIE["totalUltimoPedido"]);
                    // Declaramos la siguiente variable con el valor de elementosCookie en la posicion 2
                    $lastPedido = $elementosCookie[2];
                    // Pasamos la informacion necesaria a la funcion DAO que se encarga de cargar el ultimo pedido realizado
                    pedidoDAO::ultimoPedido($lastPedido);
                    // Cargamos la vista del carrito
                    header("Location:".URL."?controller=carrito");
                }
            }
        }
    }
?>