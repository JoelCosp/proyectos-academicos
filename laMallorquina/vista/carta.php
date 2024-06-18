<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloCartaProductos.css">
    <title>La Mallorquina | Carta de productos</title>
</head>
<body>
    
    <button id="botonFiltrarProductos" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
        <img src="img/logoEditarBlanco.svg" alt="">
    </button>
    
    <h1 id="tituloInvisible" class="tituloBorrar">PRODUCTOS FILTRADOS</h1>
    <h1 class="pt-4">ENSALADAS</h1>
    <div id="productosObten" class="row px-5 productosJs"></div>
    <div id="productoEnsalada" class="row px-5 productosJs"></div>
    <div id="productoSopa" class="row px-5 productosJs"></div>
    <div id="productoCrema" class="row px-5 productosJs"></div>
    <div class="row px-5 seccionesPhp">
        <?php
            foreach ($ensaladas as $product){      
        ?>
            <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center my-3 px-0 flex-column align-items-center tarjeta">
                <img class="imgProducto" src="img/<?= $product->getImg()?>.jpg" alt="Producto de la carta">
                <p><?= $product->getNombre()?><br></p>
                <p><b><?= $product->getPrecioUnidad()." €"?></b></p>
                <div class="row d-flex w-100 acciones">
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="" method="post">
                            <input id="btnLupa" type="submit" name="infoProducto" value="">                            
                        </form>
                    </div>
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="<?= URL ?>?controller=producto&action=añadirProductoArray" method="post">
                            <input id="btnCesta" type="submit" name="añadirCarrito" value="<?= $product->getProductoId()?>">                            
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h1 class="pt-4">SOPAS</h1>
    <div class="row px-5 seccionesPhp">
        <?php
            foreach ($sopas as $product){      
        ?>
            <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center my-3 px-0 flex-column align-items-center tarjeta">
                <img class="imgProducto" src="img/<?= $product->getImg()?>.jpg" alt="Producto de la carta">
                <p><?= $product->getNombre()?><br></p>
                <p><b><?= $product->getPrecioUnidad()." €"?></b></p>
                <div class="row d-flex w-100 acciones">
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="" method="post">
                            <input id="btnLupa" type="submit" name="infoProducto" value="">                            
                        </form>
                    </div>
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="<?= URL ?>?controller=producto&action=añadirProductoArray" method="post">
                            <input id="btnCesta" type="submit" name="añadirCarrito" value="<?= $product->getProductoId()?>">                            
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h1 class="pt-4">CREMAS</h1>
    <div class="row px-5 seccionesPhp">
        <?php
            foreach ($cremas as $product){      
        ?>
            <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center my-3 px-0 flex-column align-items-center tarjeta">
                <img class="imgProducto" src="img/<?= $product->getImg()?>.jpg" alt="Producto de la carta">
                <p><?= $product->getNombre()?><br></p>
                <p><b><?= $product->getPrecioUnidad()." €"?></b></p>
                <div class="row d-flex w-100 acciones">
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="" method="post">
                            <input id="btnLupa" type="submit" name="infoProducto" value="">                            
                        </form>
                    </div>
                    <div class="col-6 d-flex p-0 justify-content-center accion">
                        <form class="w-100" action="<?= URL ?>?controller=producto&action=añadirProductoArray" method="post">
                            <input id="btnCesta" type="submit" name="añadirCarrito" value="<?= $product->getProductoId()?>">                            
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>



    <!-- MENU LATERAL FILTROS -->

    <div class="offcanvas offcanvas-start mt-4 d-flex flex-column justify-content-between" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header justify-content-between">
            <button type="button" id="btnBorrarFiltros" data-bs-dismiss="offcanvas" aria-label="Close">Borrar filtros</button>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr>
        <div class="offcanvas-body d-flex flex-column">
            <h3>Categorías:</h3>
            <form class="d-flex justify-content-between">
                <label for="ensaladas">Ensaladas: </label>
                <input type="checkbox" id="checkEnsaladas" class="cBox">
            </form>
            <form class="d-flex justify-content-between">
                <label for="sopas">Sopas: </label>
                <input type="checkbox" id="checkSopas" class="cBox">
            </form>
            <form class="d-flex justify-content-between">
                <label for="cremas">Cremas: </label>
                <input type="checkbox" id="checkCremas" class="cBox">
            </form>
        </div>
        <div class="botonFiltrar">
            <button id="btnFilters">Filtrar</button>
        </div>
    </div>

    

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="src/productosCarta.js"></script>
</body>
</html>