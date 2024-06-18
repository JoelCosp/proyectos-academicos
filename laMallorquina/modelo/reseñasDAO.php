<?php
    class reseñasDAO{

        public static function getAllReviews() {
            $listaReviews = [];
            $con = dataBase::connect();
            if (!$con) {
                // Manejar el error de conexión si es necesario
                return $listaReviews;
            }
            $result = $con->query("SELECT * FROM review");
            if (!$result) {
                // Manejar el error de ejecución de la consulta si es necesario
                $con->close();
                return $listaReviews;
            }
            while ($reviewData = $result->fetch_assoc()) {
                $listaReviews[] = [
                    'review_id' => $reviewData['review_id'],
                    'cliente_id' => $reviewData['cliente_id'],
                    'pedido_id' => $reviewData['pedido_id'],
                    'nombre_cliente' => $reviewData['nombre_cliente'],
                    'apellido_cliente' => $reviewData['apellido_cliente'],
                    'puntuacion' => $reviewData['puntuacion'],
                    'descripcion' => $reviewData['descripcion'],
                    'fecha' => $reviewData['fecha'],
                ];
            }
            $result->close();
            $con->close();
            return $listaReviews;
        }
        
        public static function getReviewsByPunctuation($num){
            $con = dataBase::connect();
            $stmt = $con->prepare("SELECT * FROM review WHERE puntuacion = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $con->close();

            $reviews = array();

            while ($row = $result->fetch_assoc()) {
                $reviews[] = [
                    'review_id' => $row['review_id'],
                    'cliente_id' => $row['cliente_id'],
                    'pedido_id' => $row['pedido_id'],
                    'nombre_cliente' => $row['nombre_cliente'],
                    'apellido_cliente' => $row['apellido_cliente'],
                    'puntuacion' => $row['puntuacion'],
                    'descripcion' => $row['descripcion'],
                    'fecha' => $row['fecha'],
                ];
            }
            return $reviews;
        }
            
        public static function insertReview($clienteId, $pedidoId, $nombreCliente, $apellidoCliente, $puntuacion, $descripcion, $fecha){
            $con = dataBase::connect();
            $stmt = $con->prepare("INSERT INTO `review`(`cliente_id`, `pedido_id`, `nombre_cliente`, `apellido_cliente`, `puntuacion`, `descripcion`, `fecha`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssss", $clienteId, $pedidoId, $nombreCliente, $apellidoCliente, $puntuacion, $descripcion, $fecha);
            $stmt->execute();
            $con->close();
        }
        

        public static function getReviewById($id) {
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Preparamos la consulta: SELECCIONAR TODO EN LA TABLA REVIEW DONDE EL REVIEW_ID SEA IGUAL AL ID QUE LE PASAMOS
            $stmt = $con->prepare("SELECT * FROM review WHERE review_id = ?");
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado de la consulta
            $result = $stmt->get_result();
            // Cerramos la conexion
            $con->close();
            // Si el numero de registros de la consulta es superior a 0, devolvemos el objeto de tipo producto
            if ($result->num_rows > 0) {
                return $result->fetch_object('reseña');
            }
            // Si no, se devuelve null
            return null;
        }

        public static function apiGetInfoPedidoById($id) {
            $con = dataBase::connect();
            $stmt = $con->prepare("SELECT pedido.fecha_pedido, pedido_producto.producto_id, pedido_producto.cantidad, pedido_producto.precio_unidad, producto.nombre_producto, pedido.precio_total, pedido.propina, cliente.puntos, pedido.puntos_usados
            FROM pedido
            JOIN cliente ON pedido.cliente_id = cliente.cliente_id
            JOIN pedido_producto ON pedido.pedido_id = pedido_producto.pedido_id
            JOIN producto ON producto.producto_id = pedido_producto.producto_id
            WHERE pedido.pedido_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $infoPedido = array();

            while ($row = $result->fetch_assoc()) {
                $infoPedido[] = [
                    'fecha_pedido' => $row['fecha_pedido'],
                    'producto_id' => $row['producto_id'],
                    'cantidad' => $row['cantidad'],
                    'precio_unidad' => $row['precio_unidad'],
                    'nombre_producto' => $row['nombre_producto'],
                    'precio_total' => $row['precio_total'],
                    'propina' => $row['propina'],
                    'puntos_usados' => $row['puntos_usados']
                ];
            }
            return $infoPedido;
        }

        public static function userActive($id){
            $con = dataBase::connect();
            $stmt = $con->prepare("SELECT * FROM cliente WHERE cliente_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $infoUsuario = array();

            while ($row = $result->fetch_assoc()) {
                $infoUsuario[] = [
                    'cliente_id' => $row['cliente_id'],
                    'nombre' => $row['nombre'],
                    'apellido' => $row['apellido'],
                    'correo_electronico' => $row['correo_electronico'],
                    'rol' => $row['rol'],
                    'sexo' => $row['sexo'],
                ];
            }
            return $infoUsuario;
        }
        public static function obtenerReview($id){
            $con = dataBase::connect();
            $result = $con->query("SELECT count(*) AS nReviews FROM review WHERE pedido_id = '$id';");
            $row = $result->fetch_assoc();
            if($row['nReviews']){
                return true;
            }else{
                return false;
            }
        }
        
    }
?>