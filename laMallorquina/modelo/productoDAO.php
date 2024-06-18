<?php
    // Añadimos las clases necesarias para el correcto funcionamiento del controlador
    include_once 'producto.php';
    include_once 'ensalada.php';
    include_once 'sopa.php';
    include_once 'crema.php';

    class productoDAO {

        // Funcion para insertar productos
        public static function insertar($nombre, $descripcion, $precio, $categoria, $img){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Ejecutamos la misma consulta de insercion de datos con los valores que le pasamos
            $con->query("INSERT INTO producto (`nombre_producto`, `descripcion`, `precio_unidad`, `categoria_id`, `img`) VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$img')");
        }

        // Funcion para eliminar todos los productos por id
        public static function eliminar($id){
            // Creamos la conexion
            $con = dataBase::connect();
            // Ejecutamos la consulta
            $con->query("DELETE FROM `producto` WHERE `producto`.`producto_id` = $id");
        }

        // Funcion para actualizar los productos
        public static function modificar($nombre, $descripcion, $precio, $categoria, $img, $id){
            // Creamos la conexion
            $con = dataBase::connect();
            // Ejecutamos la consulta: ACTUALIZAR TABLA PRODUCTO Y APLICAMOS LOS DATOS QUE LE PASAMOS A LA FUNCION
            $con->query("UPDATE producto SET `nombre_producto` = $nombre, `descripcion` = $descripcion, `precio_unidad` = $precio,`categoria_id` = $categoria, `img` = $img  WHERE producto_id = $id");
        }

        // Obtener el producto segun el ID
        public static function getProductoById($id) {
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Preparamos la consulta: SELECCIONAR TODO EN LA TABLA PRODUCTO DONDE EL PRODUCTO_ID SEA IGUAL AL ID QUE LE PASAMOS
            $stmt = $con->prepare("SELECT * FROM producto WHERE producto_id = ?");
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado de la consulta
            $result = $stmt->get_result();
            // Cerramos la conexion
            $con->close();
            // Si el numero de registros de la consulta es superior a 0, devolvemos el objeto de tipo producto
            if ($result->num_rows > 0) {
                return $result->fetch_object('producto');
            }
            // Si no, se devuelve null
            return null;
        }

        // Obtener todos los productos segun el tipo (categoria)
        public static function getAllByType($tipo) {
            // Creamos la conexion a la base de datos
            $con = dataBase::connect();
            // Preparamos la consulta para obtener el id de la categoria segun el nombre que le pasamos
            $stmt = $con->prepare("SELECT categoria_id FROM categoria WHERE nombre_categoria = ?");
            $stmt->bind_param("s", $tipo);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado de la consulta
            $result = $stmt->get_result();
            // Inicializamos la variable categoria_id como null previamente para poder utilizarla posteriormente
            $categoria_id = null;
            // Si la consulta obtiene registros, asignamos el valor del campo de la cateforia_id a dicha variable
            if ($row = $result->fetch_assoc()) {
                $categoria_id = $row['categoria_id'];
            }
    
            // Creamos otra consulta para obtener todos los productos con el categoria_id que hemos obtenido
            $stmt = $con->prepare("SELECT * FROM producto WHERE categoria_id = ?");
            $stmt->bind_param("i", $categoria_id);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            // Declaramos el array de productos que se imprimira
            $listaProductos = [];
            // Vamos añadiendo los productos en distintos objetos segun el tipo de cateogira que tienen
            while ($productoDB = $result->fetch_object()) {
                // Creamos instancias dinámicamente según el tipo de cateogoria
                switch ($tipo) {
                    case 'Ensalada':
                        $listaProductos[] = new ensalada($productoDB);
                        break;
                    case 'Cremas':
                        $listaProductos[] = new crema($productoDB);
                        break;
                    case 'Sopas':
                        $listaProductos[] = new sopa($productoDB);
                        break;
                }
            }
            // Cerramos conexiones
            $stmt->close();
            $con->close();
            // Devolvemos el array que contiene los productos
            return $listaProductos;
        }

        public static function obtenerProductos() {
            $listaProductos = [];
            $con = dataBase::connect();
            if (!$con) {
                return $listaProductos;
            }
            $stmt = $con->prepare("SELECT * FROM producto");
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            if (!$result) {
                $con->close();
                return $listaProductos;
            }
            while ($reviewData = $result->fetch_assoc()) {
                $listaProductos[] = [
                    'producto_id' => $reviewData['producto_id'],
                    'nombre_producto' => $reviewData['nombre_producto'],
                    'descripcion' => $reviewData['descripcion'],
                    'precio_unidad' => $reviewData['precio_unidad'],
                    'categoria_id' => $reviewData['categoria_id'],
                    'img' => $reviewData['img'],
                ];
            }
            $result->close();
            $con->close();
            return $listaProductos;
        }

        public static function obtenerEnsaladas() {
            $listaEnsaladas = [];
            $con = dataBase::connect();
            if (!$con) {
                return $listaProductos;
            }
            $stmt = $con->prepare("SELECT * FROM producto WHERE categoria_id = 1");
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            if (!$result) {
                $con->close();
                return $listaProductos;
            }
            while ($reviewData = $result->fetch_assoc()) {
                $listaProductos[] = [
                    'producto_id' => $reviewData['producto_id'],
                    'nombre_producto' => $reviewData['nombre_producto'],
                    'descripcion' => $reviewData['descripcion'],
                    'precio_unidad' => $reviewData['precio_unidad'],
                    'categoria_id' => $reviewData['categoria_id'],
                    'img' => $reviewData['img'],
                ];
            }
            $result->close();
            $con->close();
            return $listaProductos;
        }

        public static function obtenerSopas() {
            $listaEnsaladas = [];
            $con = dataBase::connect();
            if (!$con) {
                return $listaProductos;
            }
            $stmt = $con->prepare("SELECT * FROM producto WHERE categoria_id = 2");
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            if (!$result) {
                $con->close();
                return $listaProductos;
            }
            while ($reviewData = $result->fetch_assoc()) {
                $listaProductos[] = [
                    'producto_id' => $reviewData['producto_id'],
                    'nombre_producto' => $reviewData['nombre_producto'],
                    'descripcion' => $reviewData['descripcion'],
                    'precio_unidad' => $reviewData['precio_unidad'],
                    'categoria_id' => $reviewData['categoria_id'],
                    'img' => $reviewData['img'],
                ];
            }
            $result->close();
            $con->close();
            return $listaProductos;
        }

        public static function obtenerCremas() {
            $listaCremas = [];
            $con = dataBase::connect();
            if (!$con) {
                return $listaProductos;
            }
            $stmt = $con->prepare("SELECT * FROM producto WHERE categoria_id = 3");
            $stmt->execute();
            // Guardamos el resultado 
            $result = $stmt->get_result();
            if (!$result) {
                $con->close();
                return $listaProductos;
            }
            while ($reviewData = $result->fetch_assoc()) {
                $listaProductos[] = [
                    'producto_id' => $reviewData['producto_id'],
                    'nombre_producto' => $reviewData['nombre_producto'],
                    'descripcion' => $reviewData['descripcion'],
                    'precio_unidad' => $reviewData['precio_unidad'],
                    'categoria_id' => $reviewData['categoria_id'],
                    'img' => $reviewData['img'],
                ];
            }
            $result->close();
            $con->close();
            return $listaProductos;
        }

        public static function getPointsByUserId($id) {
            $con = dataBase::connect();
            $stmt = $con->prepare("SELECT puntos FROM cliente WHERE cliente_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $infoUser = [];
            while ($puntosData = $result->fetch_assoc()) {
                $infoUser[] = [
                    'puntos' => $puntosData['puntos']
                ];
            }
            $result->close();
            $con->close();
            return $infoUser;
        }

        public static function actualizarPuntos($puntosRestar, $id){
            $con = dataBase::connect();
            $con->query("UPDATE cliente
                         SET puntos = (SELECT puntos 
                                       FROM cliente 
                                       WHERE cliente_id = $id) - $puntosRestar
                         WHERE cliente_id = $id");
        }
        
    }
?>