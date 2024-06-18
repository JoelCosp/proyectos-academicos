<?php
    // Se incluyen las clases necesarias para el controlador
    include_once 'modelo/producto.php';
    include_once 'modelo/pedido.php';
    include_once 'modelo/usuario.php';
    class tablaAdminDAO{

        // Funcion para obtener todos los productos de la base de datos
        public static function getAllProducts() {
            // Creamos la conexion con la base de datos
            $con = dataBase::connect();
            // Creamos la consult a realizar en la base de datos: SELECCIONAR TODOS LOS PRODUCTOS DE LA TABLA PRODUCTO
            if($result = $con->query("SELECT * FROM producto;")) {
                // Creamos un array de productos
                $products = array();
                // Se recorren los resultados de la consulta y se crean objetos (productos), añadiendolos al array
                while ($product = $result->fetch_object('producto')) {
                    $products[] = $product;
                }
                // Se devuelve el array de productos
                return $products;
            }
        }

        // Funcion para obtener todos los pedidos
        public static function getAllPedidos() {
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Realizamos la consulta: SELECCIONAR TODOS LOS PEDIDOS DE LA TABLA PEDIDO
            if($result = $con->query("SELECT * FROM pedido;")) {
                // Creamos el array de pedidos
                $pedidos = array();
                // Mientras se obtengan resultados de la consulta, se van creando objetos con dichos resultados y añadiendolos al array de pedidos
                while ($pedido = $result->fetch_object('pedido')) {
                    $pedidos[] = $pedido;
                }
                // Se devuelve el array de pedidos
                return $pedidos;
            }
        }

        // Funcion para obtener pedido segun el id del cliente
        public static function getAllMisPedidos($id) {
            // Creamos la conexion con la BBBDD
            $con = dataBase::connect();
            // Realizamos la consulta: SELECCIONAR TODOS LOS PEDIDOS DE LA TABLA PEDIDO DONDE EL CLIENTE_ID SEA = AL ID QUE LE PASAMOS
            if($result = $con->query("SELECT * FROM pedido WHERE cliente_id = $id;")) {
                // Creamos el array de los pedidos de dicho cliente
                $misPedidos = array();
                // Creamos objetos con los resultados de la consulta
                while ($miPedido = $result->fetch_object('pedido')) {
                    $misPedidos[] = $miPedido;
                }
                // Se devuelve el array
                return $misPedidos;
            }
        }

        // Funcion para insertar productos 
        public static function insertar($nombre, $descripcion, $precio, $categoria, $img){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Realizamos la consulta a la BBDD: INSERTAMOS EN LA TABLA PRODUCTO, LOS VALORES QUE LE PASAMOS A LA FUNCION 
            $con->query("INSERT INTO producto (`nombre_producto`, `descripcion`, `precio_unidad`, `categoria_id`, `img`) VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$img')");
        }

        // Funcion para eliminar productos 
        public static function eliminar($id){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Realizamos la consulta: ELIMINAR TODO DE LA TABLA PRODUCTO DONDE EL PRODUCTO_ID SEA IGUAL AL ID QUE LE PASAMOS
            $con->query("DELETE FROM `producto` WHERE `producto`.`producto_id` = $id");
        }

        // Funcion para editar productos
        public static function modificar($nombre, $descripcion, $precio, $categoria, $img, $id){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Realizamos la consulta: ACTUALIZAR LA TABLA PRODUCTOS Y ESTABLECEMOS LOS NUEVOS VALORES DONDE EL PRODUCTO_ID SEA IGUAL AL ID QUE LE PASAMOS
            $con->query("UPDATE `producto` SET `nombre_producto` = '$nombre', `descripcion` = '$descripcion', `precio_unidad` = '$precio', `categoria_id` = '$categoria', `img` = '$img' WHERE `producto_id` = $id");
        }

        // Funcion para eliminar pedidos
        public static function deletePedido($id){
            // Creamos la conexion
            $con = dataBase::connect();
            //Creamos la consulta: ELIMINAR TODO DE LA TABLA PEDIDO DONDE EL PEDIDO_ID SEA IGUAL AL PEDIDO QUE LE PASAMOS
            $con->query("DELETE FROM `pedido` WHERE `pedido_id` = $id;");
        }

        // Funcion para eliminar usuarios
        public static function deleteUsuario($id){
            //Creamos la conexion
            $con = dataBase::connect();
            //Ejecutamos la consulta: ELIMNAR TODO DE LA TABLA CLIENTE DONDE EL CLIENTE_ID SEA IGUAL AL ID QUE LE PASAMOS
            $con->query("DELETE FROM `cliente` WHERE `cliente_id` = $id;");
        }
        
        // Funcion para obtener la informacion de los usuarios
        public static function obtenerInfoUsuariosAdmin(){
            // Creamos la conexion
            $con = dataBase::connect();
            // Creamos la consulta: SELECCIONAR TODO LA INFORMACION DE LA TABLA CLIENTE
            $result = $con->query("SELECT * FROM cliente");
            // Cerramos la conexion
            $con->close();
            // Creamos el array para almacenar los usuarios
            $usuarios = array(); 
            // Si el numero de registros de la consulta es superior a 0, creamos objetos usuario con los resultados y los añadimos al array
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object('Usuario')) {
                    $usuarios[] = $row; 
                }
            }
            // Devolvemos el array de objetos usuario
            return $usuarios;  
        }
        
        // Funcion para obtener la informacion del usuario por el ID y a la que solo podra acceder el usuario administrador
        public static function obtenerInfoUsuarioAdminById($id){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Preparamos la consulta: SELECCIONAR TODO DE LA TABLA CLIENTE DONDE EL CLIENTE_ID SEA IGUAL AL ID QUE LE PASAMOS
            $stmt = $con->prepare("SELECT * FROM cliente WHERE cliente_id = ?");
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta
            $stmt->execute();
            $result = $stmt->get_result();
            // Se cierra la conexion 
            $con->close();
            // Si el numero de registros de la consulta es superior a 0, devolvemos el objeto usuario
            if ($result->num_rows > 0) {
                return $result->fetch_object('usuario');
            }
            // Si no hay resultado se devuelve null
            return null;
        }

        // Funcion para actualizar los usuarios de la BBDD  
        public static function actualizarUsuarioAdmin($nombre, $apellido, $email, $rol, $genero, $contraseña, $id){
            // Creamos la conexion con la BBDD
            $con = dataBase::connect();
            // Ejecutamos la consulta: ACTUALIZAR LA TABLA CLIENTE Y APLICAMOS LOS VALORES QUE LE PASAMOS A LA FUNCION DONDE EL CLIENTE_ID SEA IGUAL AL ID QUE LE PASAMOS
            $con->query("UPDATE `cliente` SET `nombre` = '$nombre', `apellido` = '$apellido', `correo_electronico` = '$email', `sexo` = '$genero', `contraseña` = '$contraseña' WHERE `cliente_id` = $id");
        }
    }
?>