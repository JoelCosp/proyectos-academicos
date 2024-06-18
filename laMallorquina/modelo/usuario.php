<?php
    class Usuario {
        private $clienteId;
        private $nombre;
        private $apellido;
        private $correo_electronico;
        private $rol;
        private $sexo;
        private $contraseña;

        function __construct() {
            
        }

        public function getClienteId() {
            return $this->cliente_id;
        }

        public function setClienteId($clienteId) {
            $this->cliente_id = $clienteId;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function getApellido() {
            return $this->apellido;
        }

        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }

        public function getEmail() {
            return $this->correo_electronico;
        }        

        public function setEmail($correo_electronico) {
            $this->correo_electronico = $correo_electronico;
        }

        public function getRol() {
            return $this->rol;
        }

        public function setRol($rol) {
            $this->rol = $rol;
        }

        public function getGenero() {
            return $this->sexo;
        }

        public function setGenero($sexo) {
            $this->sexo = $sexo;
        }

        public function getContraseña() {
            return $this->contraseña;
        }

        public function setContraseña($contraseña) {
            $this->contraseña = $contraseña;
        }
    }
?>
