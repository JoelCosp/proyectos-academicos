<?php
    class inicioSesionDAO{
        public static function iniciarSesion($correo, $contraseña){
            // Creamos la conexion 
            $con = dataBase::connect();
            // Declaramos la consulta: SELECCIONAR LA CONTRASEÑA DE LA TABLA CLIENTE DONDE EL CORREO_ELECTRONICO SEA IGUAL AL CORREO QUE LE HEMOS PASADO A LA FUNCION 
            $pswrdEncriptada = $con->query("SELECT contraseña FROM cliente WHERE correo_electronico = '$correo'");
            // Si el numero de registros de la consulta es superior a 0
            if ($pswrdEncriptada->num_rows > 0) {
                // Obtenemos la contraseña encriptada
                $row = $pswrdEncriptada->fetch_assoc();
                $contraseñaEncriptadaAlmacenada = $row['contraseña'];
                // Comprobamos si la contraseña obtenida coincide con la almacenada
                if (password_verify($contraseña, $contraseñaEncriptadaAlmacenada)) {
                    // Si es válida, continuamos con la lógica del inicio de sesión
                    $consultaDatos = $con->query("SELECT * FROM cliente WHERE contraseña = '$contraseñaEncriptadaAlmacenada' AND correo_electronico = '$correo'");
                    // Verificamos si la consulta devuelve algun registro
                    if ($consultaDatos->num_rows > 0) {
                        // Recorremos los campos obtenidos en la consulta
                        foreach ($consultaDatos as $row) {
                            // Asignamos el id del cliente a la variable sesion
                            $_SESSION['idCliente'] = $row['cliente_id'];
                            // Verificamos si el rol del cliente que ha iniciado sesion es administrador
                            if ($row['rol'] == 'admin' || $row['rol'] == 'Admin') {
                                // Si lo es, creamos la siguiente variable sesion para usarla posteriormente en otra funcion
                                $_SESSION['accesoAdmin'] = true;
                                // Redireccionamos la pagina a la pagina home 
                                header("Location:".URL."?controller=cuerpo"); 
                            } else {
                                // Si no, redireccionamos tambien a la pagina home porque aunque no sea usuario administrador, ha añadido la contraseña correcta 
                                header("Location:".URL."?controller=cuerpo"); 
                            }
                            exit();
                        }
                    } else {
                        // Si la consulta no devuelve registros se redirecciona de vuelta a la pagina de inicio de sesion para volver a intentarlo
                        header("Location:".URL."?controller=inicioSesion"); 
                        exit();
                    }
                } else {
                    // Si la contraseña no es válida, se redirecciona de vuelta a la pagina de inicio de sesion para volver a intentarlo
                    header("Location:".URL."?controller=inicioSesion"); 
                    exit();
                }
            } else {
                // Si el correo electrónico no existe en la base de datos, se redirecciona de vuelta a la pagina de inicio de sesion para volver a intentarlo
                header("Location:".URL."?controller=inicioSesion"); 
                exit();
            }

        }
    }
?>