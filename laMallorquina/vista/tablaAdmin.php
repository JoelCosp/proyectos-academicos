<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloTablaAdmin.css">
    <link rel="stylesheet" href="estilos/estiloPanelControl.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Tabla del administrador</title>
</head>
<body>
    <section class="mt-5">
        <h2 id="titulo">Panel de administrador</h2>
        <div class="row p-0">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/logoProducto.svg" alt="Logo sección productos admin">
                    <a href="<?= URL ?>?controller=tablaAdmin&action=indexPanelProductosAdmin">
                        <p>PANEL DE PRODUCTOS</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/logoPedido.svg" alt="Logo sección pedidos admin">
                    <a href="<?= URL ?>?controller=tablaAdmin&action=indexPanelPedidosAdmin">
                        <p>PANEL DE PEDIDOS</p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="seccionPanel p-3 d-flex jsutify-content-center align-items-center flex-column">
                    <img class="pb-3" src="img/panel1.svg" alt="Logo sección usuarios admin">
                    <a href="<?php URL ?>?controller=tablaAdmin&action=indexPanelUsuariosAdmin">
                        <p>PANEL DE USUARIOS</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>