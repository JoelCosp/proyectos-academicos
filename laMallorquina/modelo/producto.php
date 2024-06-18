<?php
    class producto{
        // Definimos las propiedades protected de la clase
        protected $producto_id;
        protected $nombre_producto;
        protected $descripcion;
        protected $precio_unidad;
        protected $categoria_id;
        protected $img;

        // Creamos un metodo constructor
        function __construct(){
            
        }

        // Creamos los getters y setters para poder obtener los datos del objeto de tipo producto
        public function getProductoId(){
            return $this->producto_id;
        }

        public function setProductoId($producto_id){
            $this->producto_id = $producto_id;
        }

        public function getNombre(){
            return $this->nombre_producto;
        }

        public function setNombre($nombre_producto){
            $this->nombre_producto = $nombre_producto;
        }

        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        public function getPrecioUnidad(){
            return $this->precio_unidad;
        }

        public function setPrecioUnidad($precio_unidad){
            $this->precio_unidad = $precio_unidad;
        }

        public function getCategoriaId(){
            return $this->categoria_id;
        }

        public function setCategoriaId($categoria_id){
            $this->categoria_id = $categoria_id;
        }

        public function getImg(){
            return $this->img;
        }

        public function setImg($img){
            $this->img = $img;
        }

        // Funcion para obtener el tipo de producto
        public static function getTipoProducto() {
            
        }
    }
?>