<?php
    include('config/dataBase.php');

    class registroDAO{

        public static function insertarCliente($nombre, $apellido, $sexo, $correo_electronico, $rol, $contraseña){
            // Creamos la conexion a la BBDD 
            $con = dataBase::connect();
            // Ejecutamos la conulta: INSERTAR LOS VALORES QUE LE PASAMOS EN LA TABLA CLIENTE
            $con->query("INSERT INTO `cliente`(`nombre`, `apellido`, `sexo`, `correo_electronico`, `rol`, `contraseña`) VALUES ('$nombre', '$apellido', '$sexo', '$correo_electronico', '$rol', '$contraseña')");
        }
    }
?>