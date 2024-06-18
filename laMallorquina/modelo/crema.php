<?php
    // Clase crema que hereda de la clase producto
    class crema extends producto{
        public function __construct($datosDB) {
            // Llama al constructor de la clase base (producto)
            parent::__construct(); 
            // Inicializa propiedades específicas de crema
            $this->producto_id = $datosDB->producto_id;
            $this->nombre_producto = $datosDB->nombre_producto;
            $this->descripcion = $datosDB->descripcion;
            $this->precio_unidad = $datosDB->precio_unidad;
            $this->categoria_id = $datosDB->categoria_id;
            $this->img = $datosDB->img;
        }

        public static function getTipoProducto() {
            return "Tipo de producto => Crema";
        }
    }
?>