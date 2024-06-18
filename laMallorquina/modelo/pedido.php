<?php
    class pedido{
        private $pedido_id;
        private $fecha_pedido;
        private $cliente_id;
        private $estado;
        private $precio_total;
        private $propina;

        function __construct(){
            
        }

        public function getPedidoId(){
            return $this->pedido_id;
        }

        public function setPedidoId($pedido_id){
            $this->pedido_id = $pedido_id;
        }

        public function getFecha(){
            return $this->fecha_pedido;
        }

        public function setFecha($fecha_pedido){
            $this->fecha_pedido = $fecha_pedido;
        }

        public function getClienteId(){
            return $this->cliente_id;
        }

        public function setClienteId($cliente_id){
            $this->cliente_id = $cliente_id;
        }

        public function getEstado(){
            return $this->estado;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }

        public function getPrecioTotal(){
            return $this->precio_total;
        }

        public function setPrecioTotal($precio_total){
            $this->precio_total = $precio_total;
        }

        public function getPropina(){
            return $this->propina;
        }

        public function setPropina($propina){
            $this->propina = $propina;
        }
    }
?>