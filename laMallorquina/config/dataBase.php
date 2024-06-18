<?php
    class dataBase {
        // Creamos la funcion para realizar la conexion con la base de datos.
        // Le tendremos que pasar los cuatro valores necesarios para realizar la conexion: el host, el user, la contraseña si se requiere y el nombre de la base de datos

        public static function connect($host='localhost', $user='root', $pwd='', $db='restaurante') {
            // Creamos la instancia mysqli que genera la conexion con la BBDD y le pasamos los parametros anteriores
            $con = new mysqli($host, $user, $pwd, $db);
            // Verificamos si se ha conectado
            // Si da algun error, se muestra el siguiente mensaje
            if($con->connect_error) {
                die('Base de datos no encontrada!');
            } else  {
                // Si no hay errores, se devuelve el objeto con la conexion
                return $con;
            }
        }
    }
?>