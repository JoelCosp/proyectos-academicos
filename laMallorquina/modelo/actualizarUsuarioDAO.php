<?php
    include_once 'usuario.php';
    class actualizarUsuarioDAO{

        // Funcion para actualizar un usuario
        public static function actualizarUsuario($nombre, $apellido, $email, $genero, $contraseña, $id){
            // Creamos la conexion con la base de datos 
            $con = dataBase::connect();
            // Ejecutamos la consulta: ACTUALIZAR LA TABLA CLIENTE Y ESTABLECER TODOS LOS PARAMETROS QUE SE LE PASAN A LA FUNCION, DONDE EL CLIENTE_ID ES IGUAL AL ID QUE LE PASAMOS
            $con->query("UPDATE `cliente` SET `nombre` = '$nombre', `apellido` = '$apellido', `correo_electronico` = '$email', `sexo` = '$genero', `contraseña` = '$contraseña' WHERE `cliente_id` = $id");
        }

        // Funcion para obtener informacion del usuario que tenga el id que le pasamos
        public static function obtenerInfoUsuario($id){
            // Creamos la conexion con la base de datos
            $con = dataBase::connect();
            // Preparamos la consulta: SELECCIONAR TODO DE LA TABLA CLIENTE DONDE EL CLIENTE_ID SEA IGUAL AL ID QUE LE PASAMOS
            $stmt = $con->prepare("SELECT * FROM cliente WHERE cliente_id = ?");
            $stmt->bind_param("i", $id);
            // Ejecutamos la consulta
            $stmt->execute();
            // Guardamos el resultado
            $result = $stmt->get_result();
            // Cerramos la conexion con la base de datos
            $con->close();
            // Si el numero de registros de la cosulta es superior a 0, se devuelve un objeto de tipo usuario
            if ($result->num_rows > 0) {
                return $result->fetch_object('usuario');
            }
            // Por contra se devuelve null
            return null;
        }
    }
?>