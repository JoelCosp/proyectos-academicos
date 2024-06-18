<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos/estiloCarrito.css" rel="stylesheet">
    <title>La Mallorquina | Cesta de la compra</title>
</head>
<body>
    <h1 class="tituloPagina">CARRITO</h1>
    <div class="row d-flex justify-content-center contenedorPrincipal">
        <div class="col-12 col-md-4 mt-4 mb-4 px-0 listaProductosAñadidos">
        <!--Si la variable de session esta vacia, se muestra el siguiente div-->
        <?php if (empty($_SESSION['lista'])) : ?>
            <div class="contenedorVacio">
                <img id="fotoCarritoVacio" class="img-fluid" src="img/logoCarritoCentro.svg" alt="Logo del carrito vacío">
                <p class="textoCarrito">¡No hay productos en tu carrito!</p>
            </div>
        <!--Por contra, se muestran los productos del carrito-->
        <?php else : ?>
            <?php foreach ($productos as $key => $producto) : ?>
            <div class="row fila-producto">
                <div class="col-12 d-flex justify-content-between align-items-center px-0 productoAñadido">
                    <div class="col-5 d-flex align-items-center">
                        <img class="py-3" src="img/<?= $producto->getImg()?>.jpg" alt="Producto de la carta">
                        <p class="ps-2"><b><?= $producto->getNombre()?></b></p>
                    </div>

                    <div class="col-5 d-flex justify-content-end">
                        <form class="panelCarrito" class="d-flex align-items-center" action="<?= URL ?>?controller=carrito&action=panelSumaResta" method="post">
                            <input type="hidden" name="cogerIdArray" value="<?= $_SESSION['lista'][$key]['id'] ?>">
                            <input is="numCant" type="number" name="" placeholder="<?= $_SESSION['lista'][$key]['cantidada'] ?>" min="1">
                            <input id="sumar" type="submit" name="sumarPlaceholder" value="+">
                            <input id="restar" type="submit" name="restarPlaceholder" value="-">
                        </form>
                        <form id="formularioBasura" action="<?= URL ?>?controller=carrito&action=botonBasura" method="post">
                            <input type="hidden" name="basura" value="<?= $producto->getProductoId()?>">
                            <input type="image" src="img/logoBasura.png" name="productoBasura" >
                        </form>
                    </div>

                    <div class="col-2 divPrecioProducto">
                        <?= $producto->getPrecioUnidad()." €"?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
            <a href="<?php URL ?>?controller=producto"><p class="mt-3">Seguir comprando</p></a>
        </div>


        <div class="col-12 col-md-3 mt-4 mb-4 ps-md-5 pe-0 infoCompra">
            <div class="d-flex justify-content-between tituloRevisar">
                <h2 class="py-3 tituloRevisar"><b>REVISAR PEDIDO</b></h2>
                <div class="d-flex">
                    <h2 class="py-3 pe-1 tituloRevisar"><b>Mis puntos: </b></h2>
                    <h2 id="puntosRellenar" class="py-3 tituloRevisar"></h2>
                </div>
            </div>
            <?php foreach ($productos as $key => $producto) : ?>    
                <div id="cProductos" class="d-flex justify-content-between">
                    <p><?= $producto->getNombre()?></p>
                    <p><?= $_SESSION['lista'][$key]['cantidada'] ?></p>
                    <p><?= $producto->getPrecioUnidad() ?></p>
                </div>   
                <?php endforeach; ?>
            <div class="d-flex justify-content-between contenedorTotal">
                <p>Transporte</p>
                <p>Gratis</p>
            </div>

            <!--CANJEAR PUNTOS-->
            <div class="d-flex justify-content-between contenedorTotal">
                <p><b>CANJEAR PUNTOS?</b></p>
                <input type="checkbox" id="dejarPuntos">
            </div>
            <div class="d-flex justify-content-between contenedorTotal">
                <input type="number" min="0" placeholder="0" id="contadorPuntos" step="100">
                <!--<button id="btnAplicar">APLICAR</button>-->
            </div>

            <!--DEJAR PROPINA-->
            <div class="d-flex justify-content-between contenedorTotal">
                <p><b>QUIERES DEJAR PROPINA?</b></p>
                <input type="checkbox" name="cantidadPropina" id="siPropina">
            </div>
            <div class="d-flex justify-content-between contenedorTotal">
                <input type="number" min="0" max="100" placeholder="3" id="contadorPropina">
            </div>

            <div class="d-flex justify-content-between contenedorTotal">
                <p><b>TOTAL</b> (IVA Incluido):</p>
                <input type="hidden" id="vTotalEscondido" value="<?= $cantidadTotal ?>">
                <p id="vPrecioTotal" class="d-flex align-items-end"><?= $cantidadTotal ?></p>
            </div>

            

            <!--Si existen las siguientes condiciones, se muestra el siguiente div -->
            <?php if (isset($_SESSION['idCliente']) && isset($idUltimoUsuario) && $_SESSION['idCliente'] == $idUltimoUsuario && isset($_COOKIE['totalUltimoPedido'])) : ?>
                <div class="d-flex justify-content-between align-items-center contenedorTotal">
                    <form class="d-flex align-items-center" action="<?= URL ?>?controller=carrito&action=cargarUltimoPedido" method="post">
                        <input type="submit" name="btnCargar" value="+">
                        <p class="ps-1">ÚLTIMO PEDIDO:</p>
                    </form>
                    <p><?= $totalUltimoPedido ?> €</p>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between mt-4 codigoPromocional">
                <h3 class="tituloCodigo">¿TIENE UN CÓDIGO PROMOCIONAL?</h3>
                <img src="img/flechaCodigo.svg" alt="Logo flecha del código promocional">
            </div>
            <?php if (isset($_SESSION['idCliente'])) : ?>
                <input id="idClienteActivo" type="hidden" value="<?= $_SESSION['idCliente'] ?>">
            <?php endif; ?>
            <form id="formularioInsertarPedido" action="<?= URL ?>?controller=pedido&action=insertarPedido" method="post">
                <input id="inputInsertarPedido" class="py-3 mt-4" type="submit" name="confirmar" value="CONFIRMAR Y PAGAR PEDIDO">
                <input type="hidden" name="valorPropinaHidden" id="cantidadPropinaAlmacenar">
                <input type="hidden" name="pTHidden" id="pTinsertar">
                <input type="hidden" name="puntosHidden" id="points">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="src/interaccionesCarrito.js"></script>
</body>
</html>