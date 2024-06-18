<?php
    class reseña {
        // Definimos las propiedades protected de la clase
        protected $review_id;
        protected $cliente_id;
        protected $pedido_id;
        protected $fecha;
        protected $nombre_cliente;
        protected $apellido_cliente;
        protected $puntuacion;
        protected $descripcion;
    
        // Creamos un método constructor
        function __construct() {
    
        }
    
        // Getters y setters para review_id
        public function getReviewId() {
            return $this->review_id;
        }
    
        public function setReviewId($review_id) {
            $this->review_id = $review_id;
        }
    
        // Getters y setters para cliente_id
        public function getClienteId() {
            return $this->cliente_id;
        }
    
        public function setClienteId($cliente_id) {
            $this->cliente_id = $cliente_id;
        }
    
        // Getters y setters para pedido_id
        public function getPedidoId() {
            return $this->pedido_id;
        }
    
        public function setPedidoId($pedido_id) {
            $this->pedido_id = $pedido_id;
        }

        // Getters y setters para fecha
        public function getFecha() {
            return $this->fecha;
        }
    
        public function setFecha($fecha) {
            $this->fecha = $fecha;
        }
    
        // Getters y setters para nombre_cliente
        public function getNombreCliente() {
            return $this->nombre_cliente;
        }
    
        public function setNombreCliente($nombre_cliente) {
            $this->nombre_cliente = $nombre_cliente;
        }
    
        // Getters y setters para apellido_cliente
        public function getApellidoCliente() {
            return $this->apellido_cliente;
        }
    
        public function setApellidoCliente($apellido_cliente) {
            $this->apellido_cliente = $apellido_cliente;
        }
    
        // Getters y setters para puntuacion
        public function getPuntuacion() {
            return $this->puntuacion;
        }
    
        public function setPuntuacion($puntuacion) {
            $this->puntuacion = $puntuacion;
        }
    
        // Getters y setters para descripcion
        public function getDescripcion() {
            return $this->descripcion;
        }
    
        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }
    }
    
?>