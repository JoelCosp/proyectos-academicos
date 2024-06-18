<?php
    include_once 'pedido.php';
    class pedidoDAO{
        // Funcion para insertar pedidos
        public static function insertarPedido($fecha, $clienteId, $total, $propina, $usedPoints){
            // Creamos la conexion con la BBBDD
            $con = dataBase::connect();
            // Declaramos la consulta: INSERTAR EN LA TABLA PEDIDO TODOS LOS VALORES QUE LE PASAMOS A LA FUNCION
            $insertarPedido = ("INSERT INTO `pedido`(`fecha_pedido`, `cliente_id`, `estado`, `precio_total`, `propina`, `puntos_usados`) VALUES ('$fecha','$clienteId', 'En proceso', '$total', '$propina', '$usedPoints')");
            // Ejecutamos la consulta
            $con->query($insertarPedido);
            // Guardamos el ultimo id insertado en una variable para poder usarlo posteriormente en otra funcion
            $idPedido = mysqli_insert_id($con);
            // Cerramos la conexion
            $con->close();
            // Devolvemos el ultimo id insertado
            return $idPedido;
        }

        // Funcion para seleccionar el precio unitario
        public static function seleccionarPrecioUnidad($productoId){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Declaramos la consulta: SELECCIONAR EL PRECIO UNITARIO DE LA TABLA PRODUCTO DONDE EL PRODUCTO_ID SEA IGUAL AL ID QUE SE LE PASA A LA FUNCION
            $pUnidad = "SELECT `precio_unidad` FROM `producto` WHERE `producto_id` ='$productoId'";
            // Ejecutamos la consulta
            $result = $con->query($pUnidad);
            // Si se ha realizado con exito, obtenemos el resultado de dicha consulta
            if ($result) {
                $row = $result->fetch_assoc();
                $precio_unidad = $row['precio_unidad'];
                // Devolvemos el resultado
                return $precio_unidad;
            } else {
                // Si no, se devuelve el error
                echo "Error en la consulta: " . $con->error;
            }
            // Cerramos conexion
            $con->close();
        }

        // Funcion para insertar en la tabla pedido_producto
        public static function insertarPedidoProducto($pedido_id, $producto_id, $cantidad, $precio_unidad){
            // Creamos la conexion
            $con = dataBase::connect();
            // Declaramos la consulta con la que insertaremos todos los datos que le pasamos a la funcion
            $insertarPedidoProducto = ("INSERT INTO `pedido_producto`(`pedido_id`, `producto_id`, `cantidad`, `precio_unidad`) VALUES ('$pedido_id','$producto_id', '$cantidad', '$precio_unidad')");
            // Ejecutamos la consulta
            $con->query($insertarPedidoProducto);
            // Cerramos la conexion
            $con->close();
        }

        // Funcion para obtener el pedido segun el id
        public static function getPedidoById($id) {
            // Creamos la conexion a la base de datos
            $con = dataBase::connect();
            // Preparamos la consulta
            $stmt = $con->prepare("SELECT * FROM pedido WHERE pedido_id = ?");
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado
            $result = $stmt->get_result();
            // Cerramos la conexion
            $con->close();
            // Si el numero de registros es superior a 0, se devuelve un objeto de tipo pedido con su informacion
            if ($result->num_rows > 0) {
                return $result->fetch_object('pedido');
            }
            // Si no, se develve null
            return null;
        }

        // Funcion para obtener el ultimo pedido
        public static function ultimoPedido($id){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Preparamos la consulta: SELECCIONAR EL PRODUCTO_ID Y LA CANTIDAD DE LA TABLA PEDIDO_PRODUCTO DONDE EL PEDIDO_ID SEA IGUAL AL ID QUE LE PASAMOS A LA FUNCION
            $stmt = $con->prepare("SELECT producto_id, cantidad FROM pedido_producto WHERE pedido_id = ?");
            // Si la preparacion de la consulta da error, se imprime un mensaje
            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $con->error);
            }
            
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta 
            $stmt->execute();
            // Guardamos el resultado de la consulta
            $result = $stmt->get_result();
            // Verificamos si la consulta devuelve algun registro
            if (mysqli_num_rows($result) > 0) {
                $key = 0;
                //Inicializamos un array en la sesion para almacenar la lista de productos
                while ($fila = mysqli_fetch_assoc($result)) {
                    $producto_id = $fila["producto_id"];
                    $cantidad = $fila["cantidad"];
                    $_SESSION['lista'][] = array('id' => $producto_id, 'cantidada' => $cantidad);
                }
            }
            // Cerramos el statement y la conexion 
            $stmt->close();
            $con->close();
        }








        // Funcion para insertar la propina
        public static function insertPropina($propina, $id){
            $con = dataBase::connect();
            $stmt = $con->prepare("UPDATE `pedido` SET `propina` = ? WHERE `pedido_id` = ?");
            
            // Vincula las variables a los marcadores de posición en la consulta preparada
            $stmt->bind_param("si", $propina, $id);
            
            // Ejecuta la sentencia preparada
            $stmt->execute();
            
            // Cierra la sentencia y la conexión
            $stmt->close();
            $con->close();
        }

        public static function insertarPuntos($puntos, $id) {
            $con = dataBase::connect();
            $stmt = $con->prepare("UPDATE `cliente` 
                                   SET `puntos` = (SELECT puntos 
                                                   FROM cliente 
                                                   WHERE cliente_id = ?) + ? 
                                   WHERE `cliente_id` = ?");
            $stmt->bind_param("iii", $id, $puntos, $id);
            $stmt->execute(); 
            $stmt->close();
            $con->close();
        }

        public static function getPointsByUserId($id) {
            $infoUser = [];
            $con = dataBase::connect();
            if (!$con) {
                return $infoUser;
            }
            $stmt = $con->prepare("SELECT `puntos` FROM `cliente` WHERE `cliente_id` = $id;");
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            if (!$result) {
                $con->close();
                return $infoUser;
            }
            while ($info = $result->fetch_assoc()) {
                $infoUser[] = [
                    'producto_id' => $info['producto_id'],
                    'nombre_producto' => $info['nombre_producto'],
                    'descripcion' => $info['descripcion'],
                    'precio_unidad' => $info['precio_unidad'],
                    'categoria_id' => $info['categoria_id'],
                    'img' => $info['img'],
                ];
            }
            $result->close();
            $con->close();
            return $infoUser;
        }

        public static function addPuntosPropina($puntosRestar, $puntosSumar, $id) {
            $con = dataBase::connect();
            // Obtener los puntos actuales
            $stmt = $con->prepare("SELECT puntos FROM cliente WHERE cliente_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($puntos);
            $stmt->fetch();
            $stmt->close();
            // Actualizar los puntos
            $nuevosPuntos = $puntos + $puntosSumar - $puntosRestar;
            $stmt = $con->prepare("UPDATE cliente SET puntos = ? WHERE cliente_id = ?");
            $stmt->bind_param("ii", $nuevosPuntos, $id);
            $stmt->execute();
            $stmt->close();
            $con->close();
        }
        
        
        
        
    }
?>      