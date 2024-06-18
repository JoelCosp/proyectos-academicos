<?php   
    include_once 'modelo/productoDAO.php';

    class productoControlador {
        public static function index(){
            if(!isset($_GET['controller'])){
                include_once 'vista/cuerpo.php';
            }else{
                include_once 'config/dataBase.php';
                include_once 'controlador/productoControlador.php';
                include_once 'modelo/productoDAO.php';
                require_once("controlador/sesionesControlador.php");
                include('vista/header.php');
                // Creamos los arrays con los tres tipos de objetos (ensaladas, sopas y cremas)
                $ensaladas = productoDAO::getAllByType('Ensalada');
                $sopas = productoDAO::getAllByType('Sopas');
                $cremas = productoDAO::getAllByType('Cremas');
                // Cargamos la vista de la carta
                include_once 'vista/carta.php';
                include("vista/seccionInfoEnvio.php");
                include('vista/footer.php');
            }
        } 
        
        // Funcion para guardar los productos que se desea comprar
        public static function añadirProductoArray(){
            // Guardamos el id del producto
            $idAñadir = $_POST['añadirCarrito'];
            
            echo $idAñadir;
            // Definimos la variable encontrado
            $encontrado = false;
            // Recorremos el array de sesion lista
            for ($i=0; $i < count($_SESSION['lista']); $i++) {
                // Si el array lista en la posicion i e id es igual al id que hemos guardado anteriormente, hacemos lo siguiente: 
                if($_SESSION['lista'][$i]['id'] == $idAñadir){
                    // El array de sesion lista en la posicion i y cantidada es igual a esa posicion + 1
                    $_SESSION['lista'][$i]['cantidada'] = $_SESSION['lista'][$i]['cantidada']  + 1;
                    // Cambiamos el valor de la variable encontrado
                    $encontrado = true;
                }
            }
            
            // Si no existe la variable encontrado, se añade el producto con la cantidad deseada al array 
            if(!$encontrado){
                array_push($_SESSION['lista'], ['id' => $idAñadir , 'cantidada'=> 1]);
            }
            // Por ultimo redireccionamos la pagina
            header("Location:".URL."?controller=producto");
            
        }
    }
?>