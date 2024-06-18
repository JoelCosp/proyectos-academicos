<?php
    include("modelo/pedidoDAO.php");
    class pedidoControlador{

        // Funcion para calcular el total del pedido a insertar
        public static function calcularTotalInsertarPedido(){
            // Inicializamos las siguientes variables
            $total = $_SESSION['lista'];
            $cantidadProducto = 0;
            $sumaPrecio = 0;
            $sumaTotal = 0;
            // Recorremos el array lista para calcular el total
            foreach ($total as $key => $value) {
                // Obtenemos los productos por el id
                $producto = productoDAO::getProductoById($_SESSION['lista'][$key]['id']);
                // La cantidad del producto es igual al array lista en la posicion key y cantidada
                $cantidadProducto = $total[$key]['cantidada'];
                // La suma del precio es la cantidad anterior por el precio_unitario del producto
                $sumaPrecio = $cantidadProducto * $producto->getPrecioUnidad();
                // La suma total es la suma total mas el valor de la variable sumaPrecio
                $sumaTotal = $sumaTotal + $sumaPrecio; 
            } 
            // Se devuelve el valor de la sumaTotal
            return $sumaTotal;
        }

        // Funcion para realizar inserts en la tabla pedido_producto
        public static function insertarPedidoProducto($pedido_id, $array){
            // Recorremos el array que se le pasa a la funcion
            foreach ($array as $key => $value){
                // Guardamos el precio unitario en una varibale 
                $precio = pedidoDAO::seleccionarPrecioUnidad($_SESSION['lista'][$key]['id']);
                // Le pasamos la informacion necesaria a la funcion DAO que realizara el insert en la BBDD
                pedidoDAO::insertarPedidoProducto($pedido_id, $_SESSION['lista'][$key]['id'], $_SESSION['lista'][$key]['cantidada'], $precio);
            }
        }

        // Funcion para insertar un pedido
        public static function insertarPedido(){
            // Comprobamos si existe la variable sesion idCliente
            if(isset($_SESSION['idCliente'])){
                // Guardamos la fecha actual
                $fecha = date('Y-m-d H:i:s');
                // Calculamos el total del pedido
                $total = self::calcularTotalInsertarPedido();
                // Guardamos el id del cliente que ha iniciado sesion
                $clienteId = $_SESSION['idCliente'];
                // Guardamos el valor de la propina 
                // Guardamos el valor de la propina
                if(isset($_POST["valorPropinaHidden"])){
                    $propina = $_POST["valorPropinaHidden"];
                }else{
                    $propina = 0;
                }

                if(isset($_POST["pTHidden"])){
                    $pt = $_POST["pTHidden"];
                }else{
                    $pt = 0;
                }

                if(isset($_POST["puntosHidden"])){
                    $ptsUsados = $_POST["puntosHidden"];
                }else{
                    $ptsUsados = 0;
                }
                
                //Insertamos el pedido y guardamos el ID del pedido insertado
                $pedido_id = pedidoDAO::insertarPedido($fecha, $clienteId, $pt, $propina, $ptsUsados);
                // Comprobamos si el insert se ha realizado correctamente
                if ($pedido_id > 0) {
                    // Pasamos la informacion necesaria a la funcion DAO que se encargara de realizar el insert en la tabla pedido_producto
                    pedidoControlador::insertarPedidoProducto($pedido_id, $_SESSION['lista']);
                }
                // Comprobamos si la siguiente cookie no existe
                if(!isset($_COOKIE['totalUltimoPedido'])){
                    // Si no existe, la creamos pasandole los valores que queremos almacenar en ella y asignandole el tiempo que queremos que dure
                    setcookie("totalUltimoPedido", $clienteId . "," . $total . "," . $pedido_id, time() + 120);
                }
                // Agregamos el ID del pedido a la URL antes de redireccionar
                $urlRedireccion = URL . "?controller=carrito&action=indexGracias&pedido_id=" . $pedido_id;
                // Por último, redireccionamos la página
                header("Location: " . $urlRedireccion);
            }
        }
    }
?>