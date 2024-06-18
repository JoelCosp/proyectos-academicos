<?php
    class cantidadesControlador {

        public static function cantidadCarrito($array){
            // Inicializamos la variable cantidad
            $cantidad = 0;
            // Recorremos el array que se le pasa a la funcion 
            for ($i=0; $i < count($array); $i++) { 
                // Por cada iteracion, se incrementa el valor de la cantidad
                $cantidad++;
            }
            // Se devuelve la cantidad 
            return $cantidad;
        }
    }

    // Asignamos el resultado de la funcion cantidadCarrito a una variable para poder usarla directamente en la vista
    $cantidad = cantidadesControlador::cantidadCarrito($_SESSION['lista']);
?>