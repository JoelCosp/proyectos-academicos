<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloPanelControl.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de control</title>
</head>
<body>
    <section class="mt-5">
        <h2 id="titulo">Su cuenta</h2>
        <div class="row p-0">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel1.svg" alt="Logo sección de información">
                    <a href="<?= URL ?>?controller=actualizarUsuario">
                        <p>INFORMACIÓN</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel2.svg" alt="Logo sección primera dirección">
                    <a href="">
                        <p>AÑADIR PRIMERA DIRECCIÓN</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel3.svg" alt="Logo sección historial de pedidos">
                    <a href="<?php URL ?>?controller=tablaAdmin&action=indexPedidoUsuario">
                        <p>HISTORIAL Y DETALLES DE MIS PEDIDOS</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="row p-0">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel4.svg" alt="Logo sección facturas por abono">
                    <a href="">
                        <p>FACTURAS POR ABONO</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel5.svg" alt="Logo sección cupones de descuento">
                    <a href="">
                        <p>CUPONES DE DESCUENTO</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel6.svg" alt="Logo sección devoluciones de mercancía">
                    <a href="">
                        <p>DEVOLUCIONES DE MERCANCÍA</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="row p-0">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel7.svg" alt="Logo sección de productos favoritos">
                    <a href="">
                        <p>PRODUCTOS FAVORITOS</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel8.svg" alt="Logo sección de reseñas">
                    <a href="<?php URL ?>?controller=reseñas&action=index">
                        <p>RESEÑAS</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel9.svg" alt="Logo sección de configuración de cookies">
                    <a href="">
                        <p>TU CONFIGURACIÓN DE COOKIES</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="d-flex justify-content-center">
        <a class="cierreSesion" href="controlador/cerrarSesionControlador.php">Cerrar sesión</a>  
    </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>
